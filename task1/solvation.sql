-- https://www.db-fiddle.com/f/5azp2FRNGs2h3FUQrRoNHL/0

CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(511) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(511) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `book_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE
);

INSERT INTO
  `book`
VALUES
  (1, 'book1'),
  (2, 'book2'),
  (3, 'book3'),
  (4, 'book4'),
  (5, 'book5'),
  (6, 'book6'),
  (7, 'book7'),
  (8, 'book8'),
  (9, 'book9');

INSERT INTO
  `author`
VALUES
  (1, 'author1'),
  (2, 'author2'),
  (3, 'author3'),
  (4, 'author4'),
  (5, 'author5');

INSERT INTO
  `book_author`
VALUES
  (null, 1, 3),
  (null, 2, 5),
  (null, 3, 2),
  (null, 1, 1),
  (null, 7, 3),
  (null, 4, 4),
  (null, 1, 5),
  (null, 9, 3),
  (null, 6, 4),
  (null, 6, 2),
  (null, 8, 1),
  (null, 5, 1),
  (null, 4, 3),
  (null, 2, 3),
  (null, 7, 4),
  (null, 9, 5);

-- Query

SELECT
  `book`.*, count(*) AS authors_count
FROM
  `book_author`
    JOIN `book` ON `book`.`id`=`book_author`.`book_id`
GROUP BY 
  `book`.`id`
HAVING 
  authors_count >= 3;
