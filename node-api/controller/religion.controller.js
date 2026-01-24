const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");

const Religion = db.religions;

//find all approved
module.exports.findAllApproved = (req, res) => {
  console.log("all approved"); 
  Religion.findAll({ where: { status: 'APPROVED' } })
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      console.error("Error while fetching approved religions:", err);
      res.status(500).send({
        message:
          err.message || "Error occurred while retrieving approved religions."
      });
    });
}

//find all by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Religion, req, res);
}