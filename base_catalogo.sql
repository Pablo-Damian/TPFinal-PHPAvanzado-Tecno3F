SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `categories`

CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcado de datos para la tabla `categories`

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Acción'),
(2, 'Aventura'),
(3, 'Deportes'),
(4, 'Estrategia'),
(5, 'Naves'),
(6, 'Lucha');

-- --------------------------------------------------------

-- Estructura de tabla para la tabla `items`

CREATE TABLE `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `year` int NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_url` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- Volcado de datos para la tabla `items`

INSERT INTO `items` (`title`, `year`, `description`, `price`, `category_id`, `created`, `modified`, `image_url`) VALUES
('Pac-Man', 1980, 'Juego de laberintos donde debes comer puntos y evitar fantasmas.', 19.99, 1, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/pacman.jpg'),
('Space Invaders', 1978, 'Defiende la Tierra de oleadas de alienígenas.', 14.99, 5, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/space_invaders.jpg'),
('Asteroids', 1979, 'Destruye asteroides y naves enemigas en el espacio.', 17.99, 5, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/asteroids.jpg'),
('Centipede', 1981, 'Dispara a los insectos antes de que te alcancen.', 12.99, 2, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/centipede.jpg'),
('Missile Command', 1980, 'Protege tus ciudades de misiles entrantes.', 15.99, 4, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/missile_command.jpg'),
('Donkey Kong', 1981, 'Rescata a la dama de Donkey Kong.', 20.99, 2, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/donkey_kong.jpg'),
('Frogger', 1981, 'Ayuda a la rana a cruzar la calle y el río.', 13.99, 2, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/frogger.jpg'),
('Pitfall!', 1982, 'Explora la jungla y evita peligros.', 18.99, 2, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/pitfall.jpg'),
('Q*bert', 1982, 'Cambia los colores de las pirámides mientras evitas enemigos.', 16.99, 2, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/qbert.jpg'),
('Galaga', 1981, 'Dispara a los alienígenas mientras te desplazas por la pantalla.', 19.99, 5, '2024-06-29 12:00:00', CURRENT_TIMESTAMP, 'path/to/galaga.jpg');