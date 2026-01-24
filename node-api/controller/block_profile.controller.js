const { db } = require("../database.js");
const { QueryTypes } = require("sequelize")
const { findByQuery } = require("./common.controller");
const moment = require("moment");

const BlockProfile = db.blockProfile;
const seq = db.sequelize;
 
// block profile
module.exports.blockProfile = (req, res) => {
  if (!req.body.block_by) {
    res.status(406).send({
      message: "block by can not be empty!"
    });
    return;
  }

  if (!req.body.block_to) {
    res.status(406).send({
      message: "block to can not be empty!"
    });
    return;
  }

  BlockProfile.max('block_id').then((block_id) => {
    //create express interest
    const blockProfile = {
      block_id: Number(block_id) + 1,
      block_by: req.body.block_by,
      block_to: req.body.block_to,
      block_date: moment().format('YYYY-MM-DD hh:mm:ss'),
    };

    //save blockProfile in database    
    BlockProfile.create(blockProfile)
      .then(data=> {
        res.send(data)
      }).catch(err => {
        console.error("Error while creating block profile:", err);
      res.status(500).send({
        message: err.message || "Some error occurred while creating the block_profile_new"
      });
    });
  });
}

module.exports.unblockProfile = (req, res) => {
  const { block_by, block_to } = req.body;
  BlockProfile.findOne({ where: { block_by, block_to }}).then((blockProfile) => {
    seq.query(`delete from block_profile_new where block_id='${blockProfile.block_id}'`,
    {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.RAW
    }).then(()=> {
      res.send({
        message: "unblocked successfully."
      });
    }).catch(err => {
      console.error("Error while unblocking profile:", err);
      res.status(500).send({
        message: err.message || "error while unblocking"
      });
    });
  }).catch(err => {
    console.error("Error while finding block profile:", err);
    res.status(404).send({
      message: err.message || "block profile not found"
    });
  });
};

//find blocked profiles by block_by
module.exports.findBlockedProfiles = (req, res) => {
  const { block_by, block_to} = req.query;
  BlockProfile.findAll({ where: { block_by, block_to }}).then((blockProfiles) => {
    res.send(blockProfiles);
  }).catch(err => {
    console.error("Error while fetching blocked profiles:", err);
    res.status(404).send({
      message: err.message || "block profile not found"
    });
  });
};


module.exports.findByQuery = (req, res) => {
  return findByQuery(BlockProfile, req, res);
};
