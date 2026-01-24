module.exports = {
    HOST: process.env.MYSQL_HOST || "localhost",

    USER: process.env.MYSQL_USER || "samyakonline_samyak",

    PASSWORD: process.env.MYSQL_PASSWORD || "8^s7kuJoukTA",

    DB: process.env.MYSQL_DB || "samyakonline_samyak",

    dialect: "mysql",

    pool: {

        max: 5,

        min: 0,

        acquire: 30000,

        idle: 10000

    }

};