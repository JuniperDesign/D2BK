# D2BK
Dare to be Kind Movement

Problems are that are known:
general user flow = madlib(name,username,category,etc)->upload story/video->complete signup(email,password)
    -establishing usermeta.id as the foreign key to build the relationship between posts and users
    -Usermeta hasMany Posts, Usermeta hasOne User
    
uploading files to upload folder
    -path and type are saved to DB, files are not being moved to folder
