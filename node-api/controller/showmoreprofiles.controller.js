const { db } = require("../database.js");
const { Op } = require("sequelize");
const { findByQuery } = require("./common.controller.js");
const { QueryTypes } = require("sequelize");
const moment = require("moment");
//const { isModuleNamespaceObject } = require("util/types");
const seq = db.sequelize;
const ShortList = db.shortList;

module.exports.bookmark = (req, res) => {
  console.log("session userId", req.query.matri_id);
  // var sql = "select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id where r.status!= 'Inactive' and fb_id!='2' and";
  // sql = sql + " r.status!='Suspended' and r.photo1 != '' and photo1_approve='APPROVED'";
  // sql = sql + " and matri_id IN (select to_id from shortlist where from_id='"+req.query.matri_id+"')";
  // sql = sql + " AND matri_id NOT IN (select block_to from block_profile where block_by='"+req.query.matri_id+"') ORDER BY r.index_id DESC";
  var sql = `SELECT * FROM shortlist WHERE from_id='${req.query.matri_id}';`;
  seq
    .query(sql, {
      // A function (or false) for logging your queries
      // Will get called for every SQL query that gets sent
      // to the server.
      logging: console.log,

      // If plain is true, then sequelize will only return the first
      // record of the result set. In case of false it will return all records.
      plain: false,

      // Set this to true if you don't have a model definition for your query.
      raw: true,

      // The type of query you are executing. The query type affects how results are formatted before they are passed back.
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error(err);
      res.status(500).send({
        message: "Error while fetching bookmark",
      });
    });
};

module.exports.addBookmark = (req, res) => {
  const { from_id, to_id } = req.body;
  ShortList.max("sh_id")
    .then((sh_id) => {
      const shortList = {
        from_id,
        to_id,
        add_date: moment().format("YYYY-MM-DD HH:mm:ss"),
        sh_id: sh_id + 1,
      };
      ShortList.create(shortList)
        .then((data) => {
          res.send(data);
        })
        .catch((err) => {
          res.status(500).send({
            message: err.message || "Some error occurred while adding bookmark",
          });
        });
    })
    .catch((err) => {
      res.status(500).send({
        message: err.message || "Some error occurred while adding bookmark",
      });
    });
};

module.exports.removeBookmark = (req, res) => {
  const { from_id, to_id } = req.body;
  ShortList.findOne({ where: { from_id, to_id } })
    .then((shortList) => {
      seq
        .query(`delete from shortlist where sh_id='${shortList.sh_id}'`, {
          logging: console.log,
          plain: false,
          raw: true,
          type: QueryTypes.RAW,
        })
        .then(() => {
          res.send({
            message: "removed bookmark successfully.",
          });
        })
        .catch((err) => {
          console.log({ err }, "error while deleting bookmark");
          res.status(500).send({
            message: err.message || "error while deleting bookmark",
          });
        });
    })
    .catch((err) => {
      res.status(404).send({
        message: err.message || "bookmark not found",
      });
    });
};

module.exports.recentpremium = async (req, res) => {
  var sql =
    "select DISTINCT * from register_view r INNER JOIN payments p ON r.matri_id=p.pmatri_id where gender!='" +
    req.query.gender +
    "'";
  sql =
    sql +
    " and fb_id!='2' and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND p.p_plan !='Free'";
  sql =
    sql +
    " and matri_id NOT IN (select block_to from block_profile where block_by='" +
    req.query.matri_id +
    "') ORDER BY pactive_dt DESC";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching recentpremium",
      });
    });
};

module.exports.recent = async (req, res) => {
  var sql =
    "select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.gender!='" +
    req.query.gender +
    "' and fb_id!='2'";
  sql =
    sql +
    " and status!='Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select pmatri_id from payments where p_plan !='Free')";
  sql =
    sql +
    " and matri_id NOT IN (select block_to from block_profile where block_by='" +
    req.query.matri_id +
    "') ORDER BY r.index_id DESC";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching recent",
      });
    });
};

//Visitor List of My Profile - who viewed my profile
module.exports.viewed = async (req, res) => {
  var sql =
    "select DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.gender!='" +
    req.query.gender +
    "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended'";
  sql =
    sql +
    " and photo1 != '' and photo1_approve='APPROVED' AND matri_id IN (select viewed_member_id from `who_viewed_my_profile` where  my_id='" +
    req.query.matri_id +
    "')";
  sql =
    sql +
    " and matri_id NOT IN (select block_to from block_profile where block_by='" +
    req.query.matri_id +
    "') ORDER BY r.index_id DESC";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching viewed",
      });
    });
};

//profiles visited by me
module.exports.visitor = async (req, res) => {
  var sql =
    "select DISTINCT r.*, v.viewed_date,p.* from register_view r INNER JOIN who_viewed_my_profile v ON r.matri_id=v.my_id INNER JOIN payment_view p ON r.matri_id = p.pmatri_id";
  sql =
    sql +
    " where r.gender!='" +
    req.query.gender +
    "' and fb_id!='2' and r.status!='Inactive' and r.status!='Suspended' and r.photo1 != '' and r.photo1_approve='APPROVED'";
  sql =
    sql +
    " and v.viewed_member_id='" +
    req.query.matri_id +
    "' and matri_id NOT IN (select block_to from block_profile where block_by='" +
    req.query.matri_id +
    "') ORDER BY v.viewed_date DESC";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      console.log("visitor data", data);
      res.send(data);
    })
    .catch((err) => {
      console.error(err);
      res.status(500).send({
        message: "Error while fetching visitor",
      });
    });
};

//Block Listed Profiles By Me
module.exports.block = async (req, res) => {
  var sql =
    "SELECT DISTINCT * from register_view r INNER JOIN payment_view p ON r.matri_id = p.pmatri_id JOIN block_profile ON block_profile.block_to=r.matri_id where";
  sql =
    sql +
    " block_profile.block_by='" +
    req.query.matri_id +
    "' and r.gender!='" +
    req.query.gender +
    "' and fb_id!='2' and r.status!='Inactive'";
  sql =
    sql +
    " and r.status!='Suspended' and r.photo1 != '' and r.photo1_approve='APPROVED' ORDER BY block_date DESC";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching blocked",
      });
    });
};

//Contact Details of profiles viewed by me
module.exports.viewedcontacts = async (req, res) => {
  var sql =
    "SELECT DISTINCT * FROM contact_checker INNER JOIN register_view ON contact_checker.viewed_id=register_view.matri_id INNER JOIN payment_view p ON register_view.matri_id = p.pmatri_id where";
  sql =
    sql +
    " contact_checker.my_id='" +
    req.query.matri_id +
    "' and fb_id!='2' and register_view.status <> 'Suspended' and register_view.status!='Inactive' and register_view.photo1 != ''";
  sql =
    sql +
    " and register_view.photo1_approve='APPROVED' ORDER BY contact_checker.date DESC";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching viewed contacts",
      });
    });
};

//Who Viewed my Contact Details
module.exports.viewedmycontacts = async (req, res) => {
  var sql =
    "select DISTINCT * from register_view INNER JOIN payment_view p ON register_view.matri_id = p.pmatri_id where matri_id IN (SELECT DISTINCT contact_checker.my_id FROM contact_checker ";
  sql =
    sql +
    " INNER JOIN register_view ON contact_checker.my_id=register_view.matri_id where contact_checker.viewed_id='" +
    req.query.matri_id +
    "' and register_view.status <> 'Suspended'";
  sql =
    sql +
    " and register_view.status!='Inactive' and register_view.photo1 != '' and register_view.photo1_approve='APPROVED' ORDER BY contact_checker.date DESC) and fb_id!='2'";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching viewed my contacts",
      });
    });
};

//Short Listed Profiles By Me
module.exports.shortlisted = async (req, res) => {
  var sql =
    "select DISTINCT * from register_view where status!= 'Inactive' and status!='Suspended' and photo1 != '' and photo1_approve='APPROVED' and ";
  sql =
    sql +
    "matri_id IN (select to_id from shortlist where from_id='" +
    req.query.matri_id +
    "') AND matri_id NOT IN (select block_to from block_profile where ";
  sql = sql + "block_by='" + req.query.matri_id + "')";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching short listed profiles",
      });
    });
};

//Check if profile is suspended
module.exports.profilesuspended = async (req, res) => {
  var sql =
    "select profile_text, family_details, part_expect from register_view where matri_id='" +
    req.query.matri_id +
    "' and status='Suspended'";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching suspended profile",
      });
    });
};

//get success story
module.exports.viewsuccess_story = async (req, res) => {
  var sql =
    "select * from success_story where weddingphoto_type='photo' and status='APPROVED'";

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching success story",
      });
    });
};

//get featured profiles
module.exports.featuredprofiles = async (req, res) => {
  if (req.query.matri_id) {
    var sql =
      "select DISTINCT * from register_view r INNER JOIN payments p ON r.matri_id=p.pmatri_id where gender!='" +
      req.query.gender +
      "'";
    sql =
      sql +
      " and fb_id!='2' and status!='Inactive' and status!='Suspended' and fstatus='Featured' and photo1 != '' and photo1_approve='APPROVED' AND p.p_plan !='Free'";
    sql =
      sql +
      " and matri_id NOT IN (select block_to from block_profile where block_by='" +
      req.query.matri_id +
      "') ORDER BY " +
      req.query.orderby +
      " " +
      req.query.order +
      " LIMIT " +
      req.query.limit +
      "";
  } else {
    var sql = `select DISTINCT * from register_view r INNER JOIN payments p ON r.matri_id=p.pmatri_id
            and fb_id!='2' and status!='Inactive' and status!='Suspended' and fstatus='Featured' and photo1 != '' and photo1_approve='APPROVED' AND p.p_plan !='Free'
             ORDER BY index_id DESC LIMIT 8`;
  }
  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching featured profiles",
      });
    });
};

module.exports.profileViewsPerDay = async (req, res) => {
  const { matri_id } = req.query;
  const today = moment().format("YYYY-MM-DD");
  const sql = `
    SELECT * FROM who_viewed_my_profile
    WHERE my_id = '${matri_id}'
      AND DATE(viewed_date) = CURDATE()
  `;

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching profile views per day",
      });
    });
}

module.exports.addWhoViewedMyProfile = async (req, res) => {
  const { my_id, viewed_member_id } = req.body;
  const viewed_date = moment().format("YYYY-MM-DD HH:mm:ss");

  const checkSql = `
    SELECT * FROM who_viewed_my_profile
    WHERE my_id = :my_id AND viewed_member_id = :viewed_member_id
  `;

  const updateSql = `
    UPDATE who_viewed_my_profile
    SET viewed_date = :viewed_date
    WHERE my_id = :my_id AND viewed_member_id = :viewed_member_id
  `;

  const insertSql = `
    INSERT INTO who_viewed_my_profile (my_id, viewed_member_id, viewed_date)
    VALUES (:my_id, :viewed_member_id, :viewed_date)
  `;

  try {
    const existingEntry = await seq.query(checkSql, {
      replacements: { my_id, viewed_member_id },
      logging: console.log,
      plain: true,
      raw: true,
      type: QueryTypes.SELECT,
    });

    if (existingEntry) {
      await seq.query(updateSql, {
        replacements: { my_id, viewed_member_id, viewed_date },
        logging: console.log,
        plain: false,
        raw: true,
        type: QueryTypes.UPDATE,
      });
      res.send({ message: "Profile view updated successfully." });
    } else {
      await seq.query(insertSql, {
        replacements: { my_id, viewed_member_id, viewed_date },
        logging: console.log,
        plain: false,
        raw: true,
        type: QueryTypes.INSERT,
      });
      res.send({ message: "Profile view recorded successfully." });
    }
  } catch (err) {
    console.error("Error in addWhoViewedMyProfile:", err);
    res.status(500).send({
      message: "Error while adding or updating who viewed my profile",
    });
  }
};