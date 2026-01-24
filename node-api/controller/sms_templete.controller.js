const { db } = require('../database.js');
const { findByQuery } = require("../controller/common.controller.js");

const SmsTemp = db.smstemp;

//retrieve approved sms templates
module.exports.findAllApproved = (req, res) => {
    console.log("all approved"); 
    SmsTemp.findAll({ where: { status: 'APPROVED' } })
      .then(data => {
        res.send(data);
      })
      .catch(err => {
        console.error("Error while fetching approved sms templates:", err);
        res.status(500).send({
          message:
            err.message || "Error occurred while retrieving approved sms templates."
        });

      });

}

//retrieve sms template by template name
module.exports.findAllByName = (req, res) => {
    const tempName = req.query.temp_name;
    SmsTemp.findAll({ where: { temp_name: tempName, status: 'APPROVED' } })
    .then(data => {
        res.send(data);
    }).catch(err => {
       res.status(500).send({
           message:
              err.message || "Error while fetching template for name."
       }); 
    });
}

//retrieve sms template by query
module.exports.findByQuery = (req, res) => {
    return findByQuery(SmsTemp, req, res);
}