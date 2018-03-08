CREATE TABLE `emarsys_api_error_logs` (
  `id`            INT          NOT NULL AUTO_INCREMENT,
  `error_message` VARCHAR(255) NOT NULL,
  `request`       TEXT         NOT NULL,
  `timestamp`     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
