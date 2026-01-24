const { DataTypes, sequelize } = require('sequelize')

module.exports = (sequelize) => {
    return sequelize.define("designation",
        {
        desg_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,
        },
        desg_name:{
            type: DataTypes.STRING(150),
            allowNull: true,
        },
        status:{
            type: DataTypes.STRING,
            allowNull: false,
        }
        },
        {
        freezeTableName: true,
        timestamps: false,
    })
};