module.exports = app => {

  const caste = require("../controller/caste.controller.js");
  var router = require("express").Router();

  //get all approved cities
  router.get("/approved",caste.findAllApproved);
  //get all by query
  router.get("/query", caste.findByQuery);

  app.use('/api/caste', router);
};