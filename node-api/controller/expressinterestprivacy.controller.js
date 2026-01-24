const { db } = require("../database.js");
const { QueryTypes } = require("sequelize")
const { findByQuery } = require("./common.controller");
const moment = require("moment");

const ExpressInterestPrivacy = db.expressinterestprivacy;
 
// create
module.exports.create = (req, res) => {
  if (!req.body.matri_id) {
    res.status(406).send({
      message: "matri id can not be empty!"
    });
    return;
  }

  ExpressInterestPrivacy.max('id').then((id) => {
    //create express interest privacy
    const expressInterestPrivacy = {
      id: Number(id) + 1,
      matri_id: req.body.matri_id,
      looking_for: req.body.looking_for,
      religion: req.body.religion,
      age_from: req.body.age_from,
      age_to: req.body.age_to,
      height_from: req.body.height_from,
      height_to: req.body.height_to,
      edu_level: req.body.edu_level,
      edu_field: req.body.edu_field,
      annual_income: req.body.annual_income,
    };

    //save expressinterestprivacy in database    
    ExpressInterestPrivacy.create(expressInterestPrivacy)
      .then(data=> {
        res.send(data)
      }).catch(err => {
        console.error("Error while creating express interest privacy:", err);
      res.status(500).send({
        message: err.message || "Some error occurred while creating the expressInterestPrivacy"
      });
    });
  });
}

// update express interest privacy
exports.update = (req, res) => {
    const matri_id = req.query.matri_id;
    console.log(req.body, "req.body")
    ExpressInterestPrivacy.update(req.body, {
      where: { matri_id: matri_id }
    })
      .then(num => {
          res.send({
            message: "express interest privacy was updated successfully."
          });
      })
      .catch(err => {
        console.error("Error while updating express interest privacy:", err);
        res.status(500).send({
          message: "Error updating express interest privacy with id=" + matri_id
        });
      });
}

module.exports.findByQuery = (req, res) => {
  return findByQuery(ExpressInterestPrivacy, req, res);
}
