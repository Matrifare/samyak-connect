const { Model } = require("sequelize");
const { DataTypes, sequelize} = require("sequelize");

module.exports = (sequelize) => {

    return sequelize.define("sms_templete",
    {
        temp_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true               
        },
        temp_name:{
            type: DataTypes.STRING(100),
            allowNull: true
        },
        temp_value:{
            type: DataTypes.STRING(1200),
            allowNull: true
        },
        status:{
            type: DataTypes.STRING,
            allowNull: false
        }
    },
    {
        freezeTableName: true,
        timestamps: false,
    })

};