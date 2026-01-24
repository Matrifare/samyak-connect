const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");

const Educationfield = db.educationFields;
  
//retrieve all approved
module.exports.findAllApproved = (req, res) => {
    console.log("all approved");
    Educationfield.findAll({ where: {status: 'APPROVED'} }).then(data => {
       res.send(data);
    }).catch(err => {
      console.error("Error while fetching all approved education fields:", err);
      res.status(500).send({
        message: "Error while fetching all approved education fields" 
      });
    });

}

//retrive all by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Educationfield, req, res);
}