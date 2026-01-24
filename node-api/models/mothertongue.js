const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("mothertongue",
    {
        mtongue_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,               
        },
        mtongue_name:{
            type: DataTypes.STRING(50),
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
    });
};