const sharp = require('sharp');
const { db } = require("../database.js");
const fs = require('fs');

const Register = db.registers;

module.exports.uploadImage = (req, res) => {
  const matriId = req.body.matri_id;
  const index = req.body.photo_name.split('photo')[1];
  const extension = req.file.originalname.split('.')[1];
  const imageName = `${matriId}_${index}.${extension}`;

  // original image
  const imageBuffer = req.file.buffer;
  sharp(imageBuffer)
    .toFile(`photos_big/${imageName}`, (error, info) => {
      if (!error) {
        Register.update({
          [req.body.photo_name]: imageName,
          [`${req.body.photo_name}_approve`]: 'UNAPPROVED',
        }, {
          where: { matri_id: matriId }
        })
          .then(() => {
              res.send({
                message: `Image upload for ${matriId} at ${req.body.photo_name} was successful.`
              });
          })
          .catch(error => {
            console.error("Error while uploading image for " + matriId + ":", error);
            res.status(500).send({
              message: "Error while uploading image for " + matriId
            });
          });
      } else {
        console.error("Error while uploading image:", error);
        res.status(500).send({
          message: `Error while uploading image: ${error.message}`,
        });
      }
    });

  // resized small image for search results
  sharp(imageBuffer)
    .resize(350, 400, { fit: 'contain' })
    .toFile(`photos/${imageName}`, (error, info) => {
      if (error) {
        console.error(error);
      }
    });
};

module.exports.deleteImage = (req, res) => {
  const { matri_id, photoFieldName } = req.body;
  Register.findOne({ where: { matri_id }, attributes: [photoFieldName] })
  .then((register) => {
    const fileName = register[photoFieldName];
    console.log('Deleting photo', fileName);
    if (fs.existsSync(`../photos/${fileName}`)) {
      console.log('inside photos');
      fs.unlinkSync(`../photos/${fileName}`);
    }
    if (fs.existsSync(`../photos_big/${fileName}`)) {
      console.log('inside photos_big');
      fs.unlinkSync(`../photos_big/${fileName}`);
    }
    Register.update({
      [photoFieldName]: '',
      [`${photoFieldName}_approve`]: 'UNAPPROVED',
    }, {
      where: { matri_id }
    })
      .then(() => {
          res.send({
            message: `Image delete for ${matri_id} at ${photoFieldName} was successful.`
          });
      })
      .catch(error => {
        console.error("Error while deleting image for " + matri_id + ":", error);
        res.status(500).send({
          message: "Error while deleting image for " + matri_id
        });
      });
  })
  .catch(error => {
      console.error("Error while fetching register entry for " + matri_id + ":", error);
      res.status(500).send({
      message: `No register entry found for ${matri_id}`
    });
  });
};