Global is the directory that contains all pictures
connect.php : the connection to the data base
main.php : where you first register your matricule/picture/certificate. it procceds to create a folder where to stock your picture
GetPhoto.php : you get the picture and certificate path, it doesn't need the database. with the matricule it checks your picture direcly in the global directory
modification.php : you can modify your photos with your matricule



For getting the uuid and different paths the files are GetPhoto.php, GetUUID. The final result is the Json $photo_data in the GetPhoto.php file  
