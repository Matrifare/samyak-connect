const moment = require("moment");

const { db } = require("../database.js");

const DescriptionApprovals = db.descriptionApprovals;

exports.update = (req, res) => {
  const matri_id = req.body.matri_id;
  console.log("description approval update", req.body)
  if (!matri_id) {
    res.status(400).send({
      message: "matri id can not be empty!"
    });
    return;
  }
  DescriptionApprovals.findOne({ where: { matri_id }}).then(() => {
    console.log(`Description approval found for ${matri_id} so updating existing`, err);
    DescriptionApprovals.update(req.body, {
      where: { matri_id: matri_id }
    })
      .then(() => {
          res.send({
            message: "Description approval was updated successfully."
          });
      })
      .catch(err => {
        console.error("Error while updating description approval:", err);
        res.status(500).send({
          message: err || "Error updating description approval with id=" + matri_id
        });
      });
  }).catch(err => {
    console.log(`Description approval not found for ${matri_id} so creating new`);
    DescriptionApprovals.max('id').then((id) => {
      const descriptionApproval = {
        id: id + 1,
        matri_id: matri_id,
        profile_text: req.body.profile_text,
        family_details: req.body.family_details,
        part_expect: req.body.part_expect,
        updated_data: req.body.updated_data,
        status: '0',
        update_date: moment().format('YYYY-MM-DD hh:mm:ss'),
      };
  
      DescriptionApprovals.create(descriptionApproval).then(data => {
        res.send(data);
      }).catch(err => {
        console.error("Error while creating description approval:", err);
        res.status(500).send({
          message: err.message || `Some error occurred while creating the description approval for ${req.body.matri_id}`,
        });
      });
    });
  });
};

exports.findOneByMatriId = (req, res) => {
  console.log("Find description approvals by matri_id", req.params.matri_id);
  DescriptionApprovals.findOne({ where: { matri_id: req.params.matri_id }}).then(data => {
    res.send(data);
  }).catch(err => {
    console.error("Error while fetching description approval data:", err);
    res.status(500).send({
      message: err || "Error while fetching description approval data",
    });
  });
};

exports.delete = (req, res) => {
  console.log("Delete description approvals", req.body.matri_id);
  DescriptionApprovals.destroy({ where: { matri_id: req.body.matri_id }})
    .then(() => {
      res.send('Successfully deleted');
    }).catch(err => {
      console.error("Error while deleting description approval:", err);
      res.status(500).send({
        message: err || `Error while deleting description approval for ${req.body.matri_id}`,
      })
    });
};