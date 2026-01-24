const { db } = require("../database.js");
const { findByQuery } = require("./common.controller");
const Designation = db.designations;

module.exports.create = (req, res) => {

  // Validate request
    if (!req.body.desg_name) {
      res.status(400).send({
        message: "Designation name can not be empty!"
      });
      return;
    }

    if (!req.body.status) {
        res.status(400).send({
          message: "status can not be empty!"
        });
        return;
      }    

    //create designation
    const designation = {
        desg_id: req.body.desg_id,
        desg_name: req.body.desg_name,
        status: req.body.status
    }

    //save designation in database    
    Designation.create(designation).then(data=> {
        res.send(data)
    }).catch(err => {
    console.error("Error while creating designation:", err);
           res.status(500).send({
           message: err.message || "Some error occurred while creating the designation"
    });

  });
  
}

//find all approved
module.exports.findAllApproved = (req, res) => {
  console.log("all approved"); 
  Designation.findAll({ where: { status: 'APPROVED' } })
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      console.error("Error while fetching approved designations:", err);
      res.status(500).send({
        message:
          err.message || "Some error occurred while retrieving approved designations."
      });
    });
}

module.exports.findByQuery = (req, res) => {
  return findByQuery(Designation, req, res);
}
