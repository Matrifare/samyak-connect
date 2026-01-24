const { db } = require("../database.js");
const { findByQuery } = require("../controller/common.controller.js");

const Educationdetail = db.educationDetails;

//retrieve all approved
module.exports.findAllApproved = (req, res) => {
    console.log("all approved");
    Educationdetail.findAll({ where: {status: 'APPROVED'} }).then(data => {
       res.send(data);
    }).catch(err => {
      console.error("Error while fetching all approved education details:", err);
      res.status(500).send({
        message: "Error while fetching all approved education details" 
      });
    });

}

//retrieve by query
module.exports.findByQuery = (req, res) => {
    return findByQuery(Educationdetail, req, res);
}
  