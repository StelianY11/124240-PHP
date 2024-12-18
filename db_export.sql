
CREATE TABLE `favorite_mangas_users` (
  `id` int(11) NOT NULL,
  `manga_id` int(11) NOT NULL,    
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
CREATE TABLE `mangas` (
  `id` int(11) NOT NULL COMMENT 'Primary Key' AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,        -- Manga title
  `author` varchar(255) NOT NULL,       -- Manga author
  `genre` varchar(255) NOT NULL,        -- Manga genre
  `description` text NOT NULL,          -- Manga description
  `image` varchar(255) NOT NULL,        -- Manga cover image
  `price` decimal(10,2) NOT NULL        -- Manga price
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `mangas` (`id`, `title`, `author`, `genre`, `description`, `image`, `price`) VALUES
(1, 'Naruto', 'Masashi Kishimoto', 'Action, Adventure', 'A young ninja embarks on an adventure to gain recognition and become the greatest ninja.', '1734346380_naruto.webp', '15.99'),
(2, 'One Piece', 'Eiichiro Oda', 'Action, Adventure', 'A young pirate aims to become the Pirate King in a world filled with pirates and treasures.', '1734346524_op.jpg', '19.99'),
(3, 'Attack on Titan', 'Hajime Isayama', 'Action, Horror', 'Humanity fights for survival against giant humanoid creatures known as Titans.', 'aot.jpg', '17.99'),
(4, 'My Hero Academia', 'Kohei Horikoshi', 'Action, Superhero', 'In a world where nearly everyone has superpowers, a young boy strives to become the greatest hero.', '1734346601_mha.jpg', '18.99'),
(5, 'Bleach', 'Tite Kubo', 'Action, Supernatural', 'A teenager gains the powers of a Soul Reaper and must protect the living world from evil spirits while solving mysteries of the afterlife.', 'bleach.png', '19.99');


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `names`, `email`, `password`) VALUES
(6, 'Симеон', 'simeon@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$QndnNTB3b0RmdUhTV2VVZQ$QfKHIMfaObI+KUoAMDhyxVKnxTQ3QvMBD+YYvy3Niks'),
(7, 'Sимеон2', 'simeon2@abv.bg', '$argon2i$v=19$m=65536,t=4,p=1$VmF4OGYzQjNWb0pOSU43bw$YUvVoKEoa5ibI9p0BG90ZYIWo38E26MewdZ3t8owjJM');
ALTER TABLE users
ADD COLUMN is_admin ENUM('user', 'admin') NOT NULL DEFAULT 'user';