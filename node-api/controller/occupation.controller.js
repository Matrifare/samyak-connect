const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");
const Occupation = db.occupations;
  
//find all approved
module.exports.findAllApproved = (req, res) => {
  console.log("all approved"); 
  Occupation.findAll({ where: { status: 'APPROVED' } })
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      console.error("Error while fetching approved occupations:", err);
      res.status(500).send({
        message:
          err.message || "Error occurred while retrieving approved occupations."
      });
    });
}

module.exports.findByQuery = (req, res) => {
  return findByQuery(Occupation, req, res);
}