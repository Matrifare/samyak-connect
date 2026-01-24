const { db } = require("../database.js");
const { findByQuery } = require("./common.controller");

const Country = db.countries; 
 
//find all approved
module.exports.findAllApproved = (req, res) => {
    console.log("all approved"); 
    Country.findAll({ where: { status: 'APPROVED' } })
      .then(data => {
        res.send(data);
      })
      .catch(err => {
        console.error("Error while fetching approved countries:", err);
        res.status(500).send({
          message:
            err.message || "Error occurred while retrieving approved countries."
        });
      });
}

module.exports.findByQuery = (req, res) => {
  return findByQuery(Country, req, res);
}
  