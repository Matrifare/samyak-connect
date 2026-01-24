const { db } = require("../database.js");
const { QueryTypes } = require("sequelize")
const { findByQuery } = require("./common.controller");
const moment = require("moment");

const seq = db.sequelize;
const ExpressInterest = db.expressinterest;
 
// request
module.exports.request = (req, res) => {
  if (!req.body.ei_sender) {
    res.status(406).send({
      message: "sender id can not be empty!"
    });
    return;
  }

  if (!req.body.ei_receiver){
    res.status(406).send({
      message: "receiver id can not be empty!"
    });
    return;
  }

  ExpressInterest.max('ei_id').then((ei_id) => {
    //create express interest
    const expressInterest = {
      ei_id: Number(ei_id) + 1,
      ei_sender: req.body.ei_sender,
      ei_receiver: req.body.ei_receiver,
      ei_message: req.body.ei_message,
      ei_sent_date: moment().format('YYYY-MM-DD hh:mm:ss'),
      status: 'UNAPPROVED',
      trash_sender: 'No',
      trash_receiver: 'No',
    };

    //save expressinterest in database    
    ExpressInterest.create(expressInterest)
      .then(data=> {
        res.send(data)
      }).catch(err => {
        console.error("Error in request:", err);
        res.status(500).send({
          message: err.message || "Some error occurred while creating the expressInterest"
        });
      });
  });
}

// respond
module.exports.respond = (req, res) => {
  if (!req.body.receiver_response) {
    res.status(406).send({
      message: "response can not be empty!"
    });
    return;
  }

  //update express interest
  ExpressInterest.update({
    receiver_response: req.body.receiver_response,
    receiver_response_date: moment().format('YYYY-MM-DD hh:mm:ss'),
  }, {
    where: { ei_sender: req.body.ei_sender, ei_receiver: req.body.ei_receiver }
  })
    .then(() => {
        res.send({
          message: "Expressed interest was updated successfully."
        });
    })
    .catch(err => {
      console.error("Error in respond:", err);
      res.status(500).send({
        message: "Error updating express ineterest with id=" + req.body.ei_sender
      });
    });
}

// pending
exports.pending = (req, res) => {
  var responseReceived = false;
  setTimeout(() => {
    if (!responseReceived) {
      res.status(504).send({
        message: "Request timed out"
      })
    }
  }, 10000);
  if (req.query.sent && JSON.parse(req.query.sent) === true) {
    console.log("approved pending sent from matri_id", req.query.matri_id);
    db.sequelize.query(`SELECT DISTINCT * FROM expressinterest AS e WHERE e.ei_sender='${req.query.matri_id}' AND e.receiver_response='Pending' AND e.trash_receiver='No' AND
    e.trash_sender='No' AND e.receiver_response='Pending'`, { type: QueryTypes.SELECT })
    .then(data => {
      responseReceived = true;
      res.send(data);
    }).catch(err => {
        responseReceived = true;
        console.error("Error in pending (sent):", err);
        res.status(500).send({
        message: err.message || "some error occurred while fetching data"
      });
    });
  } else {
    console.log("approved pending request for matri_id", req.query.matri_id);
    db.sequelize.query(`SELECT DISTINCT * FROM expressinterest AS e WHERE e.ei_receiver='${req.query.matri_id}' AND e.receiver_response='Pending' AND e.trash_receiver='No' AND
    e.trash_sender='No' AND e.receiver_response='Pending'`, { type: QueryTypes.SELECT })
    .then(data => {
      responseReceived = true;
      res.send(data);
    }).catch(err => {
        responseReceived = true;
        console.error("Error in pending (received):", err);
        res.status(500).send({
        message: err.message || "some error occurred while fetching data"
      });
    });
  }
};

//Received - Pending
module.exports.receivedPending = async(req,res) => {
    var sql ="SELECT DISTINCT expressinterest.ei_sender FROM expressinterest,register_view WHERE register_view.matri_id=expressinterest.ei_sender and ";
    sql = sql + "expressinterest.ei_receiver='"+ req.query.matri_id +"' and expressinterest.trash_receiver='No' and expressinterest.receiver_response='Pending' and ";
    sql = sql + "register_view.status <> 'Suspended'";

    await db.sequelize.query(sql,
      {
        logging: console.log,
        plain:false,
        raw:true,
        type:QueryTypes.SELECT
      }).then(data => {
        res.send(data);
      }).catch(err => {
        console.error("Error in receivedPending:", err);
        res.status(500).send({
          message: "Error while fetching short received pending responses" 
        });
      });      

};

//Received - Accepted
module.exports.receivedAccepted = async(req,res) => {
    var sql = "SELECT DISTINCT ei_sender FROM expressinterest,register_view WHERE register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='"+ req.query.matri_id +"' ";
    sql = sql + "and expressinterest.trash_receiver='No' and expressinterest.receiver_response='Accept' and register_view.status <> 'Suspended'";

    await db.sequelize.query(sql,
      {
        logging: console.log,
        plain:false,
        raw:true,
        type:QueryTypes.SELECT
      }).then(data => {
        res.send(data);
      }).catch(err => {
        console.error("Error in receivedAccepted:", err);
        res.status(500).send({
          message: "Error while fetching received accepted responses" 
        });
      });     
};

//Received - Rejected
module.exports.receivedRejected = async(req,res) => {
  var sql = "SELECT DISTINCT ei_sender FROM expressinterest,register_view WHERE register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='"+ req.query.matri_id +"' ";
  sql = sql + "and expressinterest.trash_receiver='No' and expressinterest.receiver_response='Reject' and register_view.status <> 'Suspended'";

  await db.sequelize.query(sql,
    {
      logging: console.log,
      plain:false,
      raw:true,
      type:QueryTypes.SELECT
    }).then(data => {
      res.send(data);
    }).catch(err => {
      console.error("Error in receivedRejected:", err);
      res.status(500).send({
        message: "Error while fetching received rejected responses" 
      });
    });     
};

//Sent - Pending
module.exports.sentPending = async(req,res) => {
    var sql = "SELECT DISTINCT expressinterest.ei_receiver FROM expressinterest,register_view WHERE register_view.matri_id=expressinterest.ei_receiver and ";
    sql = sql + "expressinterest.ei_sender='"+ req.query.matri_id +"' and expressinterest.trash_sender='No' and expressinterest.receiver_response='Pending' and register_view.status <> 'Suspended'";

    await db.sequelize.query(sql,
      {
        logging: console.log,
        plain:false,
        raw:true,
        type:QueryTypes.SELECT
      }).then(data => {
        res.send(data);
      }).catch(err => {
        console.error("Error in sentPending:", err);
        res.status(500).send({
          message: "Error while fetching sent pending interests" 
        });
      });      
};

//Sent - Accepted
module.exports.sentAccepted = async(req, res) => {
      var sql = "SELECT DISTINCT ei_receiver FROM expressinterest,register_view WHERE register_view.matri_id=expressinterest.ei_receiver and ";
      sql = sql + "expressinterest.ei_sender='"+ req.query.matri_id +"' and expressinterest.trash_sender='No' and expressinterest.receiver_response='Accept' and register_view.status <> 'Suspended'";

      await db.sequelize.query(sql,
        {
          logging: console.log,
          plain:false,
          raw:true,
          type:QueryTypes.SELECT
        }).then(data => {
          res.send(data);
        }).catch(err => {
          console.error("Error in sentAccepted:", err);
          res.status(500).send({
            message: "Error while fetching sent accepted interests" 
          });
        });   

};

//Sent - Rejected
module.exports.sentRejected = async(req, res) => {
        var sql = "SELECT DISTINCT ei_receiver FROM expressinterest,register_view WHERE register_view.matri_id=expressinterest.ei_receiver and ";
        sql = sql + "expressinterest.ei_sender='"+ req.query.matri_id +"' and expressinterest.trash_sender='No' and expressinterest.receiver_response='Reject' ";
        sql = sql + "and register_view.status <> 'Suspended'";

        await db.sequelize.query(sql,
          {
            logging: console.log,
            plain:false,
            raw:true,
            type:QueryTypes.SELECT
          }).then(data => {
            res.send(data);
          }).catch(err => {
            console.error("Error in sentRejected:", err);
            res.status(500).send({
              message: "Error while fetching sent accepted interests" 
            });
          });           
};

//find express interest by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(ExpressInterest, req, res);
};

//find express interest by sender and receiver
module.exports.findOne = async (req, res) => {
  var sql =
    "select * from expressinterest where 1=1 ";
  sql =
    sql +
    " and expressinterest.ei_sender='" +
    req.query.matri_id +
    "' and ei_receiver='" +
    req.query.from_id +
    "' LIMIT 1";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error("Error in findOne:", err);
      res.status(500).send({
        message: "Error while fetching expressinterest",
      });
    });
};

//express interest privacy
module.exports.checkPrivacy = async (req, res) => {
  const { from_id } = req.query;
  var sql =
    "select * from express_interest_privacy_details where matri_id = :from_id and status = 1 LIMIT 1";

  await seq
    .query(sql, {
      replacements: { from_id },
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error("Error in checkPrivacy:", err);
      res.status(500).send({
        message: "Error while fetching expressinterest",
      });
    });
};
