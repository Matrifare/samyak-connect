const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");

const Mothertongue = db.mothertongues;

//find all approved
module.exports.findAllApproved = (req, res) => {
  console.log("all approved"); 
  Mothertongue.findAll({ where: { status: 'APPROVED' } })
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      console.error("Error while fetching approved mothertongues:", err);
      res.status(500).send({
        message:
          err.message || "Error occurred while retrieving approved mothertongues."
      });
    });
}

//find all by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Mothertongue, req, res);
}