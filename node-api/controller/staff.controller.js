const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");

const Staff = db.staffs;

//retrieve all approved
module.exports.findAllApproved = (req, res) => {
  console.log("all approved");
  Staff.findAll({ where: {status: 'APPROVED'} }).then(data => {
      res.send(data);
  }).catch(err => {
    console.error("Error while fetching all approved staff details:", err);
    res.status(500).send({
      message: "Error while fetching all approved staff details" 
    });
  });

}

module.exports.findByQuery = (req, res) => {
   return findByQuery(Staff, req, res);
}