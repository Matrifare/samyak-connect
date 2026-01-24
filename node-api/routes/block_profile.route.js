module.exports = app => {

  const blockProfile = require("../controller/block_profile.controller.js");
  var router = require("express").Router();

  // block user
  router.post("/block", blockProfile.blockProfile);

  // unblock user
  router.delete("/unblock", blockProfile.unblockProfile);

  //get all by query
  router.get("/query", blockProfile.findByQuery);

  app.use('/api/block_profile', router);
};