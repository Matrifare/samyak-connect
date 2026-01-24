const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("payment_method",
    {
        pay_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,               
        },
        pay_name:{
            type: DataTypes.STRING(250),
            allowNull: true,
        },
        pay_email:{
            type: DataTypes.STRING(250),
            allowNull: true,
        },
        merchant_id:{
            type: DataTypes.STRING(250),
            allowNull: true,
        },
        check_desc:{
            type: DataTypes.STRING,
            allowNull: true,
        },
        ccavenue_id:{
            type: DataTypes.STRING(30),
            allowNull: true,
        },
        bank_detail:{
            type: DataTypes.STRING(255),
            allowNull: false,
        },
        status:{
            type: DataTypes.STRING,
            allowNull: false,
        }
    },
    {
        freezeTableName: true,
        timestamps: false,
    });
};