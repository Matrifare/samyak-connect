const { db } = require('../database.js');
const { findByQuery } = require("../controller/common.controller.js");

const EmailTemp = db.emailtemp;

//retrieve approved email templates
module.exports.findAllApproved = (req, res) => {
    console.log("all approved"); 
    EmailTemp.findAll({ where: { status: 'APPROVED' } })
      .then(data => {
        res.send(data);
      })
      .catch(err => {
        console.error("Error while fetching approved email templates:", err);
        res.status(500).send({
          message:
            err.message || "Error occurred while retrieving approved email templates."
        });

      });

}

//retrieve email template by template name
module.exports.findAllByName = (req, res) => {
    const tempName = req.query.temp_name;
    EmailTemp.findAll({ where: { EMAIL_TEMPLATE_NAME: tempName, status: 'APPROVED' } })
    .then(data => {
        res.send(data);
    }).catch(err => {
      console.error("Error while fetching template for name:", err);
       res.status(500).send({
           message:
              err.message || "Error while fetching template for name."
       }); 
    });
}

//retrieve email template by query
module.exports.findByQuery = (req, res) => {
    return findByQuery(EmailTemp, req, res);
}