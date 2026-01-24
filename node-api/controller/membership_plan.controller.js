const { db } = require("../database.js");
const { findByQuery } = require("./common.controller");

const MembershipPlan = db.membershipPlan; 
//find all approved
module.exports.findAllApproved = (req, res) => {
    console.log("all approved"); 
    MembershipPlan.findAll({ where: { status: 'APPROVED' } })
      .then(data => {
        res.send(data);
      })
      .catch(err => {
        console.error("Error while fetching approved membership plans:", err);
        res.status(500).send({
          message:
            err.message || "Error occurred while retrieving approved membership plans."
        });
      });
}

module.exports.findByQuery = (req, res) => {
  return findByQuery(MembershipPlan, req, res);
}
  