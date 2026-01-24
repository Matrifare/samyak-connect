module.exports = (app) => {
  const register = require("../controller/register.controller.js");
  var router = require("express").Router();

  //create register
  router.post("/", register.create);

  //get all register by query
  router.get("/query", register.findByQuery);

  //find all for multiple search parameters
  router.get("/multisearch", register.multipleSearch);

  //find all for multiple search parameters
  router.get("/multisearch-view", register.multipleSearchView);

  //update register
  router.put("/", register.update);

  //update matri id
  router.put("/matri_id/:id", register.updateMatriId);

  // find register from register_view using matri_id
  router.get("/findByMatriId/:matri_id", register.findByMatriId);

  router.post("/getProfiles", register.getRegistersByMatriIds);
  //find all by id
  router.post("/:id", register.findOne);

  app.use("/api/register", router);
};
