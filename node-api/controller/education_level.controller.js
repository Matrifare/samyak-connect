const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");
const Education_level = db.education_levels;

//retrieve all approved
module.exports.findAllApproved = (req, res) => {
    console.log("all approved");
    Education_level.findAll({ where: {status: 'APPROVED'} }).then(data => {
       res.send(data);
    }).catch(err => {
      console.error("Error while fetching all approved education levels:", err);
      res.status(500).send({
        message: "Error while fetching all approved education levels" 
      });
    });

}

//retrieve all by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Education_level,req,res);
}