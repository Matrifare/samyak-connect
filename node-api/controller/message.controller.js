const { db } = require("../database.js");
const { QueryTypes, Sequelize } = require("sequelize")
const { findByQuery } = require("../controller/common.controller.js");
const moment = require("moment");
const Message = db.message;
const SmsTemp = db.smstemp;
const Payments = db.payments;

//find msg by msg_id
module.exports.findOne = (req, res) => {
  console.log("find by msg id", req.params.msg_id);
  const msg_id = req.params.msg_id;
  Message.findOne({ where: { msg_id: msg_id } }).then(data => {
      res.send(data);
  }).catch(err => {
    console.error("Error while fetching message data:", err);
    res.status(500).send({
      message: "Error while fetching message data" 
    });
  });
}

//find by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Message, req, res);
}

module.exports.sendMessage = async (req, res) => {
  const { msg_from, msg_to, to_email, msg_text, msg_type, age } = req.body;
  let msg_content = msg_text;
  
  if (msg_type === 'sms') {
    const { username = '', birthdate = '', height = '', edu_name = '', ocp_name = '', city_name = '', family_city = '', mobile = '', phone = '' } = await db.sequelize.query(`SELECT * FROM register_view as register WHERE register.matri_id="${msg_from}" LIMIT 1`, { type: QueryTypes.SELECT });
    const { temp_value } = await SmsTemp.findOne({ where: { temp_name: 'SendSMS' }});
    const age = moment().diff(moment(birthdate, 'YYYY-MM-DD'), 'years');
    const heightInInch = `${Math.floor(Number(height) / 12)}ft ${Math.round(Number(height) % 12)}in`;
    let _temp = temp_value;
    _temp = _temp.replace('*profile*', msg_from);
    _temp = _temp.replace('*username*', username);
    _temp = _temp.replace('*age*', age);
    _temp = _temp.replace('*height*', heightInInch);
    _temp = _temp.replace('*edu_name*', edu_name);
    _temp = _temp.replace('*ocp_name*', ocp_name);
    _temp = _temp.replace('*city*', city_name);
    _temp = _temp.replace('*family_origin*', family_city);
    _temp = _temp.replace('*mobile*', mobile);
    _temp = _temp.replace('*phone*', phone);
    msg_content = _temp;
  }

  // Interest Shown by Samyakmatrimony Profile ID *profile* *username*, *age* Yrs, *height*, *edu_name*, *ocp_name*. Residence from *city* Family origin from *family_origin*. Mob No *mobile*/*phone*

  Message.max('msg_id').then((msg_id) => {
    const message = {
      msg_id: msg_id + 1,
      msg_to: msg_to,
      msg_from: msg_from,
      msg_subject: `Send Message from ${msg_from} to ${msg_to}`,
      msg_content,
      msg_status: 'sent',
      trash_sender: 'No',
      trash_receiver: 'No',
      msg_important_status: 'No',
      msg_read_status: 'No',
    };

    // save message in database    
    Message.create(message).then(data=> {
      res.send(data)
    }).catch(err => {
      res.status(500).send({
        message: err.message || "Some error occurred while creating the message"
      });
    });
  });

  // set r_sms = r_sms + 1 in payments 
  const paymentInfo = await Payments.findOne({ where: { pmatri_id: msg_from } });
  await Payments.update({ r_sms: paymentInfo.r_sms + 1 }, { where: { pmatri_id: msg_from } });

  // send email from samyak
  // send message from samyak
  // make voice call
}

//Received messages
module.exports.receivedMessages = async(req, res) =>{
  sql = "select DISTINCT m.msg_id,m.msg_from,m.msg_subject,m.msg_content from message m INNER JOIN register_view r ON r.email = m.msg_from where m.msg_to='"+ req.query.email +"' and m.trash_receiver='No'";
  
  await db.sequelize.query(sql,
    {
      logging: console.log,
      plain:false,
      raw:true,
      type:QueryTypes.SELECT
    }).then(data => {
      res.send(data);
    }).catch(err => {
      res.status(500).send({
        message: "Error while fetching received messages" 
      });
    });
};

//Sent messages
module.exports.sentMessages = async(req, res) =>{
  sql = "select DISTINCT m.msg_id,m.msg_to,m.msg_subject,m.msg_content from message m INNER JOIN register_view r ON r.email = m.msg_to where m.msg_from='"+ req.query.email +"' and m.trash_sender='No'";

  await db.sequelize.query(sql,
    {
      logging: console.log,
      plain:false,
      raw:true,
      type:QueryTypes.SELECT
    }).then(data => {
      res.send(data);
    }).catch(err => {
      res.status(500).send({
        message: "Error while fetching sent messages" 
      });
    });  
};