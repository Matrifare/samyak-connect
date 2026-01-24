module.exports = app => {

  const descriptionApproval = require("../controller/description_approvals.controller.js");
  var router = require("express").Router();

  // update 
  router.put("/", descriptionApproval.update);

  // get 
  router.get("/:matri_id", descriptionApproval.findOneByMatriId);

  // delete
  router.delete("/", descriptionApproval.delete);

  app.use('/api/description_approvals', router);
};