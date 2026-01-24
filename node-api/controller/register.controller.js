const { db } = require("../database.js");
const { Op, QueryTypes } = require("sequelize");
const { findByQuery } = require("../controller/common.controller.js");
const register = require("../models/register.js");
const jwt = require("jsonwebtoken");
const message = require("../models/message.js");
const Register = db.registers;
const RegisterView = db.registerViews;
//Verify Token
function verifyToken(req, res, next) {
  //Get Auth header value
  const bearerHearder = req.headers["authorization"];
  //check if bearer is undefined
  if (typeof bearerHearder != "undefined") {
    //split at the space
    console.log("inside condition");
    const bearer = bearerHearder.split(" ");
    //Get the token from array
    const bearerToken = bearer[1];
    // set the token
    req.token = bearerToken;
    //Next middleware
    next();
  } else {
    //Forbidden
    res.sendStatus(403);
  }
}

//find all by id
module.exports.findOne = (req, res) => {
  console.log("find by id", req.params.id);
  const id = req.params.id;
  Register.findByPk(id)
    .then((data) => {
      const bearerToken = req.body.token;
      if (typeof bearerToken != "undefined") {
        const token = bearerToken;
        jwt.verify(token, "secretkey", (err) => {
          if (err) {
            res.status(403).send({
              message: "Error " + err.description,
            });
          } else {
            res.status(200).send(data);
          }
        });
      }
    })
    .catch((err) => {
      res.status(500).send({
        message: "Error while fetching register data",
      });
    });
};

//find by query
module.exports.findByQuery = (req, res) => {
  return findByQuery(Register, req, res);
};

module.exports.create = (req, res) => {
  // Validate request

  if (!req.body.country_id) {
    res.status(400).send({
      message: "country id can not be empty!",
    });
    return;
  }

  if (!req.body.city) {
    res.status(400).send({
      message: "city can not be empty!",
    });
    return;
  }

  Register.max("index_id")
    .then((index_id) => {
      const crypto = require("crypto");
      const password = crypto
        .createHash("md5")
        .update(req.body.password)
        .digest("hex");
      const register = {
        index_id: index_id + 1,
        fb_id: req.body.fb_id,
        matri_id: "",
        samyak_id: req.body.samyak_id,
        prefix: req.body.prefix,
        title: req.body.title,
        description: req.body.description,
        keyword: req.body.keyword,
        email: req.body.email,
        password,
        cpassword: req.body.cpassword,
        cpass_status: req.body.cpass_status,
        m_status: req.body.m_status,
        profileby: req.body.profileby,
        time_to_call: req.body.time_to_call,
        reference: req.body.reference,
        username: req.body.username,
        firstname: req.body.firstname,
        lastname: req.body.lastname,
        gender: req.body.gender,
        birthdate: req.body.birthdate,
        birthtime: req.body.birthtime,
        birthplace: req.body.birthplace,
        tot_children: req.body.tot_children,
        status_children: req.body.status_children,
        education_level: req.body.education_level,
        education_field: req.body.education_field,
        edu_detail: req.body.edu_detail,
        income: req.body.income,
        occupation: req.body.occupation,
        emp_in: req.body.emp_in,
        monthly_sal: req.body.monthly_sal,
        designation: req.body.designation,
        other_caste: req.body.other_caste,
        religion: req.body.religion,
        caste: req.body.caste,
        subcaste: req.body.subcaste,
        gothra: req.body.gothra,
        star: req.body.star,
        moonsign: req.body.moonsign,
        horoscope: req.body.horoscope,
        manglik: req.body.manglik,
        m_tongue: req.body.m_tongue,
        height: req.body.height,
        weight: req.body.weight,
        b_group: req.body.b_group,
        disability: req.body.disability,
        complexion: req.body.complexion,
        bodytype: req.body.bodytype,
        diet: req.body.diet,
        smoke: req.body.smoke,
        drink: req.body.drink,
        languages_known: req.body.languages_known,
        address: req.body.address,
        country_id: req.body.country_id,
        state_id: req.body.state_id,
        city: req.body.city,
        phone: req.body.phone,
        mobile: req.body.mobile,
        residence: req.body.residence,
        living_status: req.body.living_status,
        house_ownership: req.body.house_ownership,
        father_name: req.body.father_name,
        mother_name: req.body.mother_name,
        father_living_status: req.body.father_living_status,
        mother_living_status: req.body.mother_living_status,
        father_occupation: req.body.father_occupation,
        mother_occupation: req.body.mother_occupation,
        profile_text: req.body.profile_text,
        looking_for: req.body.looking_for,
        family_origin: req.body.family_origin,
        family_details: req.body.family_details,
        family_value: req.body.family_value,
        family_type: req.body.family_type,
        family_status: req.body.family_status,
        no_of_brothers: req.body.no_of_brothers,
        no_of_sisters: req.body.no_of_sisters,
        no_marri_brother: req.body.no_marri_brother,
        no_marri_sister: req.body.no_marri_sister,
        part_frm_age: req.body.part_frm_age,
        part_to_age: req.body.part_to_age,
        part_bodytype: req.body.part_bodytype,
        part_diet: req.body.part_diet,
        part_smoke: req.body.part_smoke,
        part_drink: req.body.part_drink,
        part_income: req.body.part_income,
        part_emp_in: req.body.part_emp_in,
        part_occupation: req.body.part_occupation,
        part_designation: req.body.part_designation,
        part_expect: req.body.part_expect,
        part_height: req.body.part_height,
        part_height_to: req.body.part_height_to,
        part_complexion: req.body.part_complexion,
        part_mtongue: req.body.part_mtongue,
        part_religion: req.body.part_religion,
        part_caste: req.body.part_caste,
        part_manglik: req.body.part_manglik,
        part_star: req.body.part_star,
        part_edu: req.body.part_edu,
        part_edu_level: req.body.part_edu_level,
        part_edu_field: req.body.part_edu_field,
        part_country_living: req.body.part_country_living,
        part_state: req.body.part_state,
        part_city: req.body.part_city,
        part_resi_status: req.body.part_resi_status,
        part_native_place: req.body.part_native_place,
        hobby: req.body.hobby,
        hor_check: req.body.hor_check,
        hor_photo: req.body.hor_photo,
        photo_protect: req.body.photo_protect,
        photo_pswd: req.body.photo_pswd,
        video: req.body.video,
        video_approval: req.body.video_approval,
        video_url: req.body.video_url,
        video_view_status: req.body.video_view_status,
        photo_view_status: req.body.photo_view_status,
        photo1: req.body.photo1,
        photo1_approve: req.body.photo1_approve,
        photo1_update_date: req.body.photo1_update_date,
        photo2: req.body.photo2,
        photo2_approve: req.body.photo1_approve,
        photo3: req.body.photo3,
        photo3_approve: req.body.photo3_approve,
        photo4: req.body.photo4,
        photo4_approve: req.body.photo4_approve,
        photo5: req.body.photo5,
        photo5_approve: req.body.photo5_approve,
        photo6: req.body.photo6,
        photo6_approve: req.body.photo6_approve,
        photo7: req.body.photo7,
        photo7_approve: req.body.photo7_approve,
        photo8: req.body.photo8,
        photo8_approve: req.body.photo8_approve,
        reg_date: req.body.reg_date,
        ip: req.body.ip,
        agent_approve: req.body.agent_approve,
        last_login: req.body.last_login,
        fstatus: req.body.fstatus,
        logged_in: req.body.logged_in,
        franchised_by: req.body.franchised_by,
        terms: "Yes",
        status: "Inactive",
        adminrole_view_status: "Yes",
        mobile_verify_status: "No",
        email_verify_status: "No",
        contact_view_security: "1",
        agent: "",
        adminrole_id: "1",
      };

      // save register in database
      Register.create(register)
        .then((data) => {
          res.send(data);
        })
        .catch((err) => {
          console.error("Error while creating register:", err);
          res.status(500).send({
            message:
              err.message || "Some error occurred while creating the register",
          });
        });
    })
    .catch((err) => {
      console.error("Error while creating register:", err);
      res.status(500).send({
        message:
          err.message || "Some error occurred while creating the register",
      });
    });
};

exports.update = (req, res) => {
  const matri_id = req.query.matri_id;
  console.log(req.body, "req.body");
  Register.update(req.body, {
    where: { matri_id: matri_id },
  })
    .then((num) => {
      res.send({
        message: "Register was updated successfully.",
      });
    })
    .catch((err) => {
      console.error("Error while updating register:", err);
      res.status(500).send({
        message: "Error updating Register with id=" + matri_id,
      });
    });
};

exports.updateMatriId = (req, res) => {
  const id = req.params.id;
  console.log(req.body.matri_id);
  Register.update(
    { matri_id: req.body.matri_id },
    {
      where: { index_id: id },
    }
  )
    .then((num) => {
      if (num == 1) {
        res.send({
          message: "Matri Id updated successfully.",
        });
      } else {
        res.send({
          message: `Cannot update Matri id for id=${id}. Maybe Register was not found or req.body is empty!`,
        });
      }
    })
    .catch((err) => {
      console.error("Error while updating Matri id:", err);
      res.status(500).send({
        message: "Error updating Matri id for id=" + id,
      });
    });
};

exports.multipleSearch = (req, res) => {
  let queryObject = {};
  queryObject.where = {};
  console.log(req.query, "req.query");
  queryObject.attributes = [
    "email",
    "matri_id",
    "birthdate",
    "firstname",
    "lastname",
    "gender",
    "photo1",
    "height",
    "religion",
    "last_login",
    "reg_date",
    "city",
    "edu_detail",
    "occupation",
  ];
  Object.keys(req.query).forEach((fieldName) => {
    const value = req.query[fieldName];
    if (
      ![
        "age_from",
        "age_to",
        "height_from",
        "height_to",
        "photo_search",
        "page",
        "limit",
      ].includes(fieldName) &&
      value != ""
    ) {
      queryObject.where[fieldName] = value;
    }
  });
  const {
    age_from,
    age_to,
    height_from,
    height_to,
    photo_search,
    page = 0,
    limit = 10,
    sort_by = "last_login",
  } = req.query;
  if (age_from && age_to) {
    queryObject.where.birthdate = {
      [Op.between]: [age_to, age_from],
    };
  }
  if (height_from && height_to) {
    queryObject.where.height = {
      [Op.between]: [height_from, height_to],
    };
  }
  if (photo_search) {
    queryObject.where.photo1 = {
      [Op.and]: [
        {
          [Op.ne]: null,
        },
        {
          [Op.ne]: "",
        },
      ],
    };
  }
  queryObject.order = [[sort_by, "DESC"]];
  queryObject.limit = limit;
  queryObject.offset = page * limit;
  console.log("Limit:", limit, "Offset:", page * limit);
  Register.findAndCountAll(queryObject)
    .then((data) => {
      console.log("response data", data);
      res.send(data);
    })
    .catch((err) => {
      console.error("Error while fetching register data:", err);
      res.status(500).send({
        message: err.message || "Error while fetching register data",
      });
    });
};

exports.multipleSearchView = (req, res) => {
  let queryObject = {};
  queryObject.where = {};
  console.log(req.query, "req.query");
  queryObject.attributes = [
    "index_id",
    "matri_id",
    "m_status",
    "birthdate",
    "firstname",
    "lastname",
    "gender",
    "photo1",
    "photo1_approve",
    "height",
    "religion",
    "last_login",
    "reg_date",
    "city_name",
    "country_name",
    "edu_name",
    "ocp_name",
    "religion_name",
    "fstatus",
    "photo_protect",
    "photo_view_status",
    "profile_text",
    "profileby",
  ];
  Object.keys(req.query).forEach((fieldName) => {
    const value = req.query[fieldName];
    if (
      ![
        "age_from",
        "age_to",
        "height_from",
        "height_to",
        "photo_search",
        "page",
        "limit",
      ].includes(fieldName) &&
      value != ""
    ) {
      queryObject.where[fieldName] = value;
    }
  });
  const {
    age_from,
    age_to,
    height_from,
    height_to,
    photo_search,
    page = 0,
    limit = 8,
    sort_by = "last_login",
  } = req.query;
  if (age_from && age_to) {
    queryObject.where.birthdate = {
      [Op.between]: [age_to, age_from],
    };
  }
  if (height_from && height_to) {
    queryObject.where.height = {
      [Op.between]: [height_from, height_to],
    };
  }
  if (photo_search) {
    queryObject.where.photo1 = {
      [Op.and]: [
        {
          [Op.ne]: null,
        },
        {
          [Op.ne]: "",
        },
      ],
    };
  }
  queryObject.order = [[sort_by, "DESC"]];
  queryObject.limit = limit;
  queryObject.offset = page == 1 ? 0 : page * limit;
  console.log("Limit:", limit, "Offset:", page * limit);
  RegisterView.findAndCountAll(queryObject)
    .then((data) => {
      console.log("response data", data);
      res.send(data);
    })
    .catch((err) => {
      console.error("Error while fetching register view data:", err);
      res.status(500).send({
        message: err.message || "Error while fetching register view data",
      });
    });
};

//find by matri_id
exports.findByMatriId = (req, res) => {
  console.log("Find by matri_id", req.params.matri_id);
  db.sequelize
    .query(
      `SELECT register.*, 
      (SELECT GROUP_CONCAT( DISTINCT '', religion_name, ''SEPARATOR ', ' ) AS part_religion FROM register a INNER JOIN religion b ON FIND_IN_SET(b.religion_id, a.part_religion) > 0 where a.matri_id = "${req.params.matri_id}"  GROUP BY a.part_religion) AS part_religion,
      (SELECT GROUP_CONCAT( DISTINCT '', caste_name, ''SEPARATOR ', ' ) AS part_caste FROM register a INNER JOIN caste b ON FIND_IN_SET(b.caste_id, a.part_caste) > 0 where a.matri_id = "${req.params.matri_id}"  GROUP BY a.part_caste) AS part_caste,
      (SELECT GROUP_CONCAT( DISTINCT '', mtongue_name, ''SEPARATOR ', ' ) AS part_mtongue FROM register a INNER JOIN mothertongue b ON FIND_IN_SET(b.mtongue_id, a.part_mtongue) > 0 where a.matri_id = "${req.params.matri_id}"  GROUP BY a.part_mtongue) AS part_mtongue,
      (SELECT GROUP_CONCAT( DISTINCT ' ', country_name, ''SEPARATOR ', ' ) AS part_country FROM register a INNER JOIN country b ON FIND_IN_SET(b.country_id, a.part_country_living) > 0 where a.matri_id = "${req.params.matri_id}"  GROUP BY a.part_country_living) AS part_country,
      (SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_city) > 0 where a.matri_id = "${req.params.matri_id}"  GROUP BY a.part_city) AS part_city,
      (SELECT GROUP_CONCAT( DISTINCT ' ', city_name, ''SEPARATOR ', ' ) AS part_native_city FROM register a INNER JOIN city b ON FIND_IN_SET(b.city_id, a.part_native_place) > 0 where a.matri_id = "${req.params.matri_id}" GROUP BY a.part_native_place) AS part_native_city,
      (SELECT GROUP_CONCAT(DISTINCT '', e_level_name, ''SEPARATOR ', ' ) AS part_edu_level FROM register a INNER JOIN education_level b ON FIND_IN_SET(b.e_level_id, a.part_edu_level) > 0 where a.matri_id = "${req.params.matri_id}"  GROUP BY a.part_edu_level) AS part_edu_level,
      (SELECT GROUP_CONCAT(DISTINCT '', e_field_name, ''SEPARATOR ', ' ) AS part_edu_field FROM register a INNER JOIN education_field b ON FIND_IN_SET(b.e_field_id, a.part_edu_field) > 0 where a.matri_id = "${req.params.matri_id}"  GROUP BY a.part_edu_field) AS part_edu_field,
      (SELECT GROUP_CONCAT( DISTINCT ' ', ocp_name, ''SEPARATOR ', ' ) AS part_occupation FROM register a INNER JOIN occupation b ON FIND_IN_SET(b.ocp_id, a.part_occupation) > 0 where a.matri_id = "${req.params.matri_id}" GROUP BY a.part_occupation) AS part_occupation
       FROM register_view as register
      WHERE register.matri_id="${req.params.matri_id}" LIMIT 1`,
      { type: QueryTypes.SELECT }
    )
    .then((data) => {
      res.send(data[0]);
    })
    .catch((err) => {
      console.error("Error while fetching register data:", err);
      res.status(500).send({
        message: err.message || "some error occurred while fetching data",
      });
    });
};

exports.getRegistersByMatriIds = async (req, res) => {
  try {
    const { matri_ids } = req.body;
    if (!Array.isArray(matri_ids) || matri_ids.length === 0) {
      return res.status(400).send({ error: 'matri_ids should be a non-empty array' });
    }
    const fields = [
      "matri_id",
      "firstname",
      "lastname",
      "gender",
      "birthdate",
      "height",
      "religion_name",
      "edu_name",
      "education_level",
      "education_field",
      "ocp_name",
      "city_name",
      "family_city",
      "last_login",
      "photo1",
      "photo_protect",
      "looking_for"
    ];

    const registers = await RegisterView.findAll({
      attributes: fields,
      where: {
        matri_id: {
          [Op.in]: matri_ids,
        },
      },
    });

    return res.status(200).send(registers);
  } catch (error) {
    console.error('Error fetching registers by matri_ids:', error);
    return res.status(500).send({ error: 'Internal Server Error' });
  }
};
