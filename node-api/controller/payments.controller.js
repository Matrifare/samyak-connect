const { db } = require("../database.js");
const { Op } = require("sequelize")
const { findByQuery } = require("../controller/common.controller.js");
const Payments = db.payments;

//find payment by matri_id
module.exports.findOne = (req, res) => {
  console.log("find by matri id", req.params.matri_id);
  const matri_id = req.params.matri_id;
  Payments.findOne({ where: { pmatri_id: matri_id } }).then(data => {
    res.send(data);
  }).catch(err => {
    console.error("Error while fetching payment data:", err);
    res.status(500).send({
      message: "Error while fetching payments data"
    });
  });
}

//find by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Payments, req, res);
}

module.exports.create = (req, res) => {
  Payments.max('payid').then((payid) => {
    const payment = {
      payid: payid + 1,
      pmatri_id: req.body.pmatri_id,
      pname: req.body.pname,
      pemail: req.body.pemail,
      pmobile: req.body.pmobile,
      paymode: req.body.paymode,
      pactive_dt: req.body.pactive_dt,
      p_plan: req.body.p_plan,
      plan_duration: req.body.plan_duration,
      profile: req.body.profile,
      video: 'YES',
      chat: 'YES',
      p_no_contacts: req.body.p_no_contacts,
      p_amount: req.body.p_amount,
      p_bank_detail: req.body.p_bank_detail,
      pay_id: req.body.pay_id,
      p_msg: req.body.p_msg,
      r_profile: 0,
      r_cnt: 0,
      r_sms: 0,
      exp_date: req.body.exp_date,
      current_plan: 'YES',
    };

    // save payment in database    
    Payments.create(payment).then(data => {
      res.send(data)
    }).catch(err => {
      res.status(500).send({
        message: err.message || "Some error occurred while creating the payment"
      });
    });
  }).catch(err => {
    res.status(500).send({
      message: err.message || "Some error occurred while creating the payment"
    });
  });
}

//update payment my matri_id
exports.update = (req, res) => {
  const matri_id = req.query.matri_id;
  console.log(req.body, "req.body")
  Payments.update(req.body, {
    where: { pmatri_id: matri_id }
  })
    .then(num => {
      res.send({
        message: "Payment was updated successfully."
      });
    })
    .catch(err => {
      res.status(500).send({
        message: "Error updating Payment with id=" + matri_id
      });
    });
}
