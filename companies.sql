CREATE TABLE IF NOT EXISTS `companies` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL
);

INSERT INTO `companies` (`name`, `description`) VALUES
('Abarca', 'Abarca is a premiere insurance company, offering coverage to millions.'),
('Aetna', 'Aetna is also a wonderful insurance company.'),
('Blue Cross', 'Blue Cross is an even better company.');
