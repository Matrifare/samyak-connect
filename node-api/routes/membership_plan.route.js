module.exports = app => {

  const membership_plan = require("../controller/membership_plan.controller.js");
  var router = require("express").Router();
  //get all approved cities
  router.get("/approved",membership_plan.findAllApproved);
  //get all by query
  router.get("/query", membership_plan.findByQuery);

  app.use('/api/membership_plan', router);
};