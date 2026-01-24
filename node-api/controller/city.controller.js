const { db } = require("../database.js");
const { findByQuery } = require("./common.controller");

const City = db.cities; 

module.exports.create = (req, res) => {

    // Validate request
      if (!req.body.city_id) {
        res.status(400).send({
          message: "city id name can not be empty!"
        });
        return;
      }
      
      if (!req.body.status) {
          res.status(400).send({
            message: "status can not be empty!"
          });
          return;
      }    
  
      //create city
      const city = {
          city_id: req.body.city_id,
          country_code: req.body.country_code,
          state_code: req.body.state_code,
          city_name: req.body.city_name,
          status: req.body.status
      }
  
      //save city in database    
      City.create(city).then(data=> {
          res.send(data)
      }).catch(err => {
      console.error("Error while creating city:", err);
             res.status(500).send({
             message: err.message || "Some error occurred while creating the city"
      });
  
    });
    
  }  

//find all approved
module.exports.findAllApproved = (req, res) => {
    console.log("all approved"); 
    City.findAll({ where: { status: 'APPROVED' } })
      .then(data => {
        res.send(data);
      })
      .catch(err => {
        console.error("Error while fetching approved cities:", err);
        res.status(500).send({
          message:
            err.message || "Error occurred while retrieving approved cities."
        });
      });
}

module.exports.findByQuery = (req, res) => {
  return findByQuery(City, req, res);
}
  