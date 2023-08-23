--
-- Database: `comments`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE comment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
COMMIT;