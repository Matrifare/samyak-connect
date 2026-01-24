const { DataTypes } = require('sequelize');

module.exports = (sequelize) => {
    return sequelize.define("description_approvals",
    {    
      id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      matri_id:{
        type: DataTypes.STRING(50),
        allowNull: false,
      },
      profile_text:{
        type: DataTypes.STRING(1000),
        allowNull: true,
      },
      family_details:{
        type: DataTypes.STRING(1000),
        allowNull: true,
      },
      part_expect:{
        type: DataTypes.STRING(1000),
        allowNull: true,
      },
      updated_data:{
        type: DataTypes.ENUM('1','2','3'),
        allowNull: false,
      },
      status:{
        type: DataTypes.ENUM('0','1','2'),
        allowNull: false,
      },
      update_date: {
        type: DataTypes.DATE,
        allowNull: false,
      }
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};