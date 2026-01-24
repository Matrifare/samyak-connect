const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");
const Paymentmethod = db.paymentmethods;

//retrieve all approved
module.exports.findAllApproved = (req, res) => {
  console.log("all approved");
  Paymentmethod.findAll({ where: {status: 'APPROVED'} }).then(data => {
      res.send(data);
  }).catch(err => {
    console.error("Error while fetching all approved payment method details:", err);
    res.status(500).send({
      message: "Error while fetching all approved payment method details" 
    });
  });

}

//retrieve all by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Paymentmethod, req, res);
}