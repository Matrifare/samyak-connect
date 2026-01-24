module.exports = app => {

  const photoUploadController = require("../controller/photo_upload.controller.js");
  var router = require("express").Router();

  // upload photo
  router.post("/upload", photoUploadController.uploadImage);

  // delete photo
  router.post("/delete", photoUploadController.deleteImage);

  app.use('/api/photo_upload', router);
};