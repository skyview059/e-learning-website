DROP TABLE IF EXISTS `jos_theories`;
 
CREATE TABLE `jos_theories` (
  `theory_id` int(11) NOT NULL auto_increment,
  `theory_objective` varchar(255),
  `theory_name` varchar(255),
  `theory_file_dat_path` varchar(255),
  `theory_file_video_path` varchar(255),
  `theory_description` varchar(255),

	
  PRIMARY KEY (`theory_id`)
);
 
INSERT INTO  `jos_theories` (
`theory_id` ,
`theory_objective` ,
`theory_name` ,
`theory_file_dat_path` ,
`theory_file_video_path` ,
`theory_description`
)
VALUES (
NULL ,  'Mục tiêu của bài lý thuyết',  'Tên bài lý thuyết',  'http://localhost/e-learning-website/data/TheoryContent/lythuyet.dat', 'http://localhost/e-learning-website/data/TheoryVideo/boy.flv',  'Giới thiệu chung về bài lý thuyết'
);