const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("login_logs",
    {
        id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,               
        },
        matri_id:{
            type: DataTypes.STRING(8),
            allowNull: false,
        },
        login_time:{
            type: DataTypes.TIME,
            allowNull: false,
        },
        server_ip:{
            type: DataTypes.STRING(15),
            allowNull: false,
        },
        client_ip:{
            type: DataTypes.STRING(15),
            allowNull: false,
        },
        url:{
            type: DataTypes.STRING,
            allowNull: false,
        },
        browser:{
            type: DataTypes.STRING(400),
            allowNull: false,
        },
        user_session:{
            type: DataTypes.STRING(200),
            allowNull: false,
        }
    },
    {
        freezeTableName: true,
        timestamps: false,
    });
};