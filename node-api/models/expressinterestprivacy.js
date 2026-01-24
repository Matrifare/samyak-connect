const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {
    return sequelize.define("expressinterestprivacy",
    {    
      id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      matri_id:{
        type: DataTypes.STRING(10),
        allowNull: false
      },
      looking_for:{
        type: DataTypes.STRING(150),
        allowNull: true
      },
      religion:{
        type: DataTypes.STRING(100),
        allowNull: true
      },
      age_from:{
        type: DataTypes.INTEGER,
        allowNull: true
      },
      age_to:{
        type: DataTypes.INTEGER,
        allowNull: true
      },
      height_from:{
        type: DataTypes.INTEGER,
        allowNull: true
      },
      height_to:{
        type: DataTypes.INTEGER,
        allowNull: true
      },
      edu_level:{
        type: DataTypes.STRING(250),
        allowNull: true
      },
      edu_field:{
        type: DataTypes.STRING(250),
        allowNull: true
      },
      annual_income:{
        type: DataTypes.STRING(250),
        allowNull: true
      },
      with_photo:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      status:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      page:{
        type: DataTypes.ENUM('1','2'),
        allowNull: false
      },
      created_at:{
        type: DataTypes.DATE,
        allowNull: false
      },
      updated_at:{
        type: DataTypes.DATE,
        allowNull:true
      }
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};