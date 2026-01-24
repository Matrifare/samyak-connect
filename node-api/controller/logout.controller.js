const { db } = require("../database.js");
const Register = db.registers;

//logout
module.exports.logoutUser = (req, res) => {
  // Get matri_id from session if not provided in body
  const matri_id = req.body.matri_id || req.session.userId;

  if (!matri_id) {
    // If no matri_id, just destroy the session and clear cookies
    req.session.destroy((err) => {
      res.clearCookie("qid");
      if (err) {
        console.log("Error destroying session:", err);
        res.status(500).send({
          message: "Some error occurred while logout",
        });
        return;
      }
      res.status(200).send({
        message: "User logged out successfully",
      });
    });
    return;
  }

  Register.findOne({ where: { matri_id: matri_id } })
    .then((user) => {
      if (user) {
        req.session.destroy((err) => {
          res.clearCookie("qid");
          if (err) {
            console.log("Error destroying session:", err);
            res.status(500).send({
              message: "Some error occurred while logout",
            });
            return;
          }
          res.status(200).send({
            message: "User logged out successfully",
          });
        });
      } else {
        // User not found, but still destroy session and clear cookies
        req.session.destroy((err) => {
          res.clearCookie("qid");
          if (err) {
            console.log("Error destroying session:", err);
            res.status(500).send({
              message: "Some error occurred while logout",
            });
            return;
          }
          res.status(200).send({
            message: "User logged out successfully",
          });
        });
      }
    })
    .catch((err) => {
      console.error("Error while logging out user:", err);
      // Even if there's an error, try to destroy session and clear cookies
      req.session.destroy((sessionErr) => {
        res.clearCookie("qid");
        if (sessionErr) {
          console.log("Error destroying session:", sessionErr);
        }
        res.status(500).send({
          message: err.message || "Some error occurred while logout",
        });
      });
    });
};
