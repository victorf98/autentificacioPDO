CREATE TABLE `admin` (
 `user` varchar(30) NOT NULL,
 `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

CREATE TABLE `concursant` (
 `id` varchar(20) NOT NULL,
 `nom` varchar(20) NOT NULL,
 `imatge` varchar(70) NOT NULL,
 `amo` varchar(40) NOT NULL,
 `raça` varchar(20) NOT NULL,
 `fase` int(11) NOT NULL,
 `vots` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

CREATE TABLE `fase` (
 `nFase` int(5) NOT NULL,
 `dataInici` date NOT NULL,
 `dataFi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4