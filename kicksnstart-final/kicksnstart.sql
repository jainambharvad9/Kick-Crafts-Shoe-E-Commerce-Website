-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 05:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kicksnstart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `role` enum('superadmin','admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`, `first_name`, `last_name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '1234', 'admin@gmail.com', 'meet', 'malvaniya', 'admin', '2024-11-08 10:43:14', '2024-11-08 10:52:25'),
(2, 'meet', '123', 'meet@gmail.com', 'meet', 'malvaniya', 'admin', '2024-11-08 11:32:52', '2024-11-08 11:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'men', 'men'),
(2, 'women', 'women');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending',
  `shipping_address` varchar(255) DEFAULT NULL,
  `order_status` enum('Processing','Shipped','Delivered','Cancelled') DEFAULT 'Processing',
  `tracking_number` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `payment_status`, `shipping_address`, `order_status`, `tracking_number`, `updated_at`) VALUES
(1, 3, '2024-11-17 23:25:08', 9500.00, 'Paid', 'Indian', 'Delivered', NULL, '2024-11-23 16:43:58'),
(2, 2, '2024-11-17 23:31:25', 120895.00, 'Paid', 'USA', 'Delivered', NULL, '2024-11-23 16:45:10'),
(3, 2, '2024-11-17 23:39:24', 8250.00, 'Paid', 'Indian', 'Delivered', NULL, '2024-11-23 16:46:17'),
(4, 2, '2024-11-17 23:45:23', 8250.00, 'Paid', 'Indian', 'Delivered', NULL, '2024-11-28 14:46:38'),
(5, 2, '2024-11-17 23:50:12', 8500.00, 'Pending', 'Indian', 'Processing', NULL, '2024-11-17 18:20:12'),
(7, 2, '2024-11-18 02:59:41', 14450.00, 'Paid', 'Indian', 'Delivered', NULL, '2024-11-23 16:47:52'),
(8, 2, '2024-11-18 11:51:07', 9999.00, 'Pending', 'Indian', 'Processing', NULL, '2024-11-18 06:21:07'),
(9, 2, '2024-11-18 11:54:00', 59995.00, 'Pending', 'Indian', 'Processing', NULL, '2024-11-18 06:24:00'),
(10, 3, '2024-11-18 13:20:13', 8250.00, 'Pending', 'Indian', 'Processing', NULL, '2024-11-18 07:50:13'),
(11, 6, '2024-11-23 21:08:21', 14250.00, 'Pending', 'KHARI SHERI CHAMUNDA MA GOKH PASE DHRANGADHRA', 'Processing', NULL, '2024-11-23 15:38:21'),
(12, 3, '2024-12-03 08:50:12', 10.00, 'Paid', NULL, 'Processing', NULL, '2024-12-03 03:20:12'),
(13, 3, '2024-12-03 09:04:27', 10.00, 'Paid', NULL, 'Processing', NULL, '2024-12-03 03:34:27'),
(14, 1, '2024-12-03 10:12:48', 10.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-03 04:42:48'),
(15, 1, '2024-12-03 10:20:56', 10.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-03 04:50:56'),
(16, 1, '2024-12-03 10:30:59', 6200.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-03 05:00:59'),
(17, 1, '2024-12-03 10:46:57', 8250.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-03 05:16:57'),
(18, 1, '2024-12-03 10:54:46', 4995.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-03 05:24:46'),
(19, 1, '2024-12-03 11:08:08', 8250.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-03 05:38:08'),
(20, 1, '2024-12-03 11:24:17', 8250.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-03 05:54:17'),
(21, 1, '2024-12-10 21:06:26', 12150.00, 'Paid', 'Default Address', 'Processing', NULL, '2024-12-10 15:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`) VALUES
(2, 2, 5, 2, 9250.00, 18500.00),
(3, 2, 3, 2, 6200.00, 12400.00),
(4, 2, 15, 5, 17999.00, 89995.00),
(5, 3, 2, 1, 8250.00, 8250.00),
(6, 4, 2, 1, 8250.00, 8250.00),
(7, 5, 9, 1, 8500.00, 8500.00),
(8, 7, 2, 1, 8250.00, 8250.00),
(9, 7, 3, 1, 6200.00, 6200.00),
(10, 8, 29, 1, 9999.00, 9999.00),
(11, 9, 28, 5, 11999.00, 59995.00),
(12, 10, 2, 1, 8250.00, 8250.00),
(13, 11, 4, 1, 14250.00, 14250.00),
(18, 16, 3, 1, 6200.00, 6200.00),
(19, 17, 2, 1, 8250.00, 8250.00),
(20, 18, 1, 1, 4995.00, 4995.00),
(21, 19, 2, 1, 8250.00, 8250.00),
(22, 20, 2, 1, 8250.00, 8250.00),
(23, 21, 8, 1, 12150.00, 12150.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `brand`, `price`, `stock`, `category_id`, `size`, `color`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Nike Court Vision Low Next Nature', 'In love with the classic look of \'80s basketball but have a thing for the fast-paced culture of today\'s game? Meet the Nike Court Vision Low. A classic remixed with at least 20% recycled materials by weight, its crisp upper and stitched overlays keep the soul of the original style. The plush, low-cut collar keeps it sleek and comfortable for your world.\r\n', NULL, 4995.00, 200, 1, '9,10', 'brown', NULL, '2024-11-16 12:21:08', '2024-11-16 12:21:08'),
(2, 'Nike Dunk Low Retro', 'Recognising the Dunk\'s roots as the top-ranking university-team sneaker, the Be True To Your School Pack looks to the original ad campaign for inspiration. Colours represent top-flight universities, while crisp leather has the perfect amount of sheen to make \'em a hands-down win. So lace up and show off that varsity spirit. Are you game?\r\n', NULL, 8250.00, 248, 1, '8,9,10', 'blue', NULL, '2024-11-16 12:22:27', '2024-11-18 07:50:13'),
(3, 'Nike SB Force 58', 'The latest and greatest innovation to hit the streets, the Force 58 gives you the durability of a cupsole with the flexibility of vulcanised shoes. Made from canvas and suede and finished with perforations on the toe, the whole look is infused with heritage basketball DNA.\r\n', NULL, 6200.00, 249, 1, '8,9,10', 'yellow', NULL, '2024-11-16 12:25:13', '2024-11-17 21:29:41'),
(4, 'Nike ACG Torre Mid Waterproof', 'Out of the archives, into the wild. After decades of exploration in forests and mountainous terrain, the beloved ACG hiker from \'95 is back for more. And just like Dad\'s dusty old crag-chasers, it comes dressed for adventure. The waterproof upper mixes shaggy suede with textile materials for durability, while hefty tread brings the grip. This weather-ready design helps you get out there—whenever the outdoors decides to call your name.\r\n', NULL, 14250.00, 99, 1, '10', 'gray', NULL, '2024-11-16 12:26:34', '2024-11-23 15:38:21'),
(5, 'Nike Dunk High Retro', 'Created for the hardwood but taken to the streets, the \'80s basketball icon returns with perfectly sheened overlays and original university colours. With its classic hoops design, the Nike Dunk High Retro channels \'80s vintage back onto the streets while its padded, high-top collar adds an old-school look rooted in comfort.\r\n', NULL, 9250.00, 250, 1, '9,10', 'black', NULL, '2024-11-16 12:27:36', '2024-11-16 12:27:36'),
(6, 'Nike Attack', 'Mac Attack! These shoes are a 1:1 recreation of John McEnroe\'s iconic \'80s look. Channel his rebellious nature with bold colour-blocking and graphics to stand out from the sea of Triple Whites.\r\n', NULL, 10250.00, 150, 1, '10,11', 'gray', NULL, '2024-11-16 12:28:43', '2024-11-16 12:28:43'),
(7, 'Nike Terminator High', 'Untouched, unaltered and straight from the vault—you get the picture. The Terminator High lets you step back to the era of hook shots, knee pads and calf-high socks. Crisp leather keeps your look smoother than backboard glass and retro branding delivers a big varsity finish.\r\n', NULL, 12150.00, 150, 1, '9,10,11', 'brown', NULL, '2024-11-16 12:29:54', '2024-11-16 12:29:54'),
(8, 'Nike Attack Premium', 'Yin and yang. The passion of the mercurial. Balance is found beyond the boundaries with this 1:1 bring-back of a famous tennis court look. The breezy textiles are wrapped in smooth leather with crackled suede accents for retro appeal. Complete with rolled leather edges, visible stitching and iconic \'80s style, the Attack is ready for you to break the mould.\r\n', NULL, 12150.00, 200, 1, '8,10', 'white', NULL, '2024-11-16 12:31:28', '2024-11-16 12:31:28'),
(9, 'Nike Blazer Low Pro Club', 'A classic with a twist. This low-top take on the Blazer Mid Pro Club pays homage to its heritage while stepping into a modern space. The exposed foam on the tongue keeps the look you love, and stitching around the Swoosh logo and midsole adds a new look.\r\n', NULL, 8500.00, 349, 1, '8,9,10', 'orange', NULL, '2024-11-16 12:32:38', '2024-11-17 18:20:12'),
(10, 'Air Jordan 1 Mid SE', 'New colours and fresh textures update this all-time favourite without losing its classic look and familiar feel. Made from premium materials and pumped full of comfortable Nike Air cushioning, it features subtle details that make it a staple sneaker with a modern expression.\r\n', NULL, 12500.00, 250, 1, '9,10', 'gray', NULL, '2024-11-16 12:33:51', '2024-11-16 12:33:51'),
(11, 'Jordan Spizike Low', 'The Spizike takes elements of five classic Jordans, combines them and gives you one iconic sneaker. It\'s an homage to Spike Lee formally introducing Hollywood and hoops in a culture moment. You get a great-looking pair of kicks with some history. What more can you ask for? Ya dig?\r\n', NULL, 15000.00, 250, 1, '9,10', 'black', NULL, '2024-11-16 12:35:16', '2024-11-16 12:35:16'),
(12, 'Air Jordan Legacy 312 Low', 'Celebrate MJ\'s legacy with this shout-out to Chicago\'s 312 area code. With elements from three iconic Jordans (the AJ3, AJ1 and Air Alpha Force), it\'s a modern mash-up that reps the best.\r\n', NULL, 12999.00, 250, 1, '8,9,10', 'black', NULL, '2024-11-16 12:36:30', '2024-11-23 15:46:48'),
(13, 'Jordan One Take 5 PF', 'Accelerate, bank, shoot, score—then repeat. Russell Westbrook\'s latest shoe is here to assist your speed game, helping you stay unstoppable on the break. The outer eyestay and wraparound toe piece add containment on the court. Energy-returning Air Zoom cushioning in the forefoot helps keep you sinking \'em from the 1st to the 4th.\r\n', NULL, 8699.00, 450, 1, '9,10', 'white', NULL, '2024-11-16 12:37:45', '2024-11-16 12:37:45'),
(14, 'Air Jordan 4 RM', 'These sneakers reimagine the instantly recognisable AJ4 for life on the go. We centred comfort and durability while keeping the heritage look you love. Max Air in the heel cushions your every step, and elements of the upper—the wing, eyestay and heel—are blended into a strong, flexible cage that wraps the shoe to add a toughness to your everyday commute.\r\n', NULL, 12800.00, 350, 1, '9,10,11', 'black', NULL, '2024-11-16 12:38:50', '2024-11-16 12:38:50'),
(15, 'Air Jordan 1 Retro High OG', 'The Air Jordan 1 Retro High remakes the classic sneaker, giving you a fresh look with a familiar feel. Premium materials with new colours and textures give modern expression to an all-time favourite.\r\n', NULL, 17999.00, 100, 1, '10', 'golden', NULL, '2024-11-16 12:39:55', '2024-11-16 12:39:55'),
(16, 'Nike Air Force 1 Shadow', 'Everything you love about the AF-1—but doubled! The Air Force 1 Shadow puts a playful twist on a hoops icon to highlight the best of AF-1 DNA. With 2 eyestays, 2 mudguards, 2 backtabs and 2 Swoosh logos, you get a layered look with double the branding.\r\n', NULL, 11999.00, 450, 2, '9,10', 'white', NULL, '2024-11-16 13:08:58', '2024-11-16 13:08:58'),
(17, 'Nike Court Legacy Lift', 'Elevate your style with the Court Legacy Lift. Its platform midsole delivers a bold statement on top of the clean, easy-to-wear design. And don\'t worry, we\'ve kept the classic Court fit you know and love.\r\n', NULL, 7155.00, 400, 2, '8,9', 'yellow', NULL, '2024-11-16 13:10:25', '2024-11-16 13:10:25'),
(18, 'Nike Dunk Low Premium', 'Take a walk on the wild side with our classic Safari print. This Dunk Low combines premium materials with plush padding for game-changing comfort that lasts. It balances textured overlays against a smooth leather upper, plus a radial perforation pattern on the toe box for an elevated finish. The possibilities are endless—how will you wear your Dunks?\r\n', NULL, 11999.00, 350, 2, '9,10', 'white', NULL, '2024-11-16 13:11:43', '2024-11-16 13:11:43'),
(19, 'Jordan Stadium 90', 'Evolve your game. The Stadium 90 takes elements from the greats and forges them into something entirely unique. Combining iconic design elements from the AJ1 and AJ5, this is a new classic with an emphasis on comfort, durability and stability.\r\n', NULL, 12150.00, 300, 2, '8,9,10', 'white', NULL, '2024-11-16 13:13:23', '2024-11-16 13:13:23'),
(20, 'Nike Dunk Low Next Nature SE', 'The Dunk returns with classic construction, throwback hoops flair and seasonal colours. Channelling \'80s style back onto the streets, its padded, low-cut collar lets you take your game anywhere—in comfort. Plus, this special edition includes metallic charms so you can personalise your kicks.\r\n', NULL, 10250.00, 300, 2, '9,10', 'green', NULL, '2024-11-16 13:15:17', '2024-11-16 13:15:17'),
(21, 'Nike Air Max Ishod', 'Infused with elements taken from iconic \'90s hoops shoes, the Air Max Ishod is built with all the durability you need to skate hard. This creative twist on the original Ishod design features updated mesh, exposed Nike Air (with Max Air technology) and a cupsole that breaks in easily. Now step in and skate like you mean it.\r\n', NULL, 9999.00, 250, 2, '8,9,10', 'green', NULL, '2024-11-16 13:16:16', '2024-11-16 13:16:16'),
(22, 'Nike Air Force 1 \'07 LX', 'Premium materials. Aged finishes. Cushioned comfort. We kept everything you love about the AF-1, including its throwback hoops style and comfy, low-cut collar. This version makes a subdued statement with a mix of smooth and textured leather.\r\n', NULL, 11250.00, 300, 2, '8,9,10', 'blue', NULL, '2024-11-16 13:17:34', '2024-11-16 13:17:34'),
(23, 'Nike Air Max 90', 'Lace up and feel the legacy. Produced at the intersection of art, music and culture, this champion running shoe helped define the \'90s. Modern updates like mixed materials and exposed Air cushioning keep it alive and well. Green accents and iridescent pops celebrate Air Max Day.\r\n', NULL, 13249.00, 300, 2, '8,9,10', 'green', NULL, '2024-11-16 13:18:38', '2024-11-16 13:18:38'),
(24, 'Nike Blazer Mid \'77 Vintage', 'Styled for the \'70s. Loved in the \'80s. Classic in the \'90s. Ready for the future. The Blazer Mid delivers a timeless design that\'s easy to wear. The era-echoing suede breaks in beautifully and is paired with bold branding for a premium feel. Exposed foam on the tongue and a special midsole finish make it look like you\'ve just pulled them from the history books. Go ahead—perfect your outfit.\r\n', NULL, 9999.00, 350, 2, '9,10', 'gray', NULL, '2024-11-16 13:19:54', '2024-11-16 13:19:54'),
(25, 'Air Jordan 5 Retro \'Lucky Green\'', 'Lucky Green is back again, bringing its charm to the AJ5. This auspicious edition brings white leather and Lucky Green accents to the original design\'s famously bold aesthetic. The fierce zig-zag midsole detail and iconic lace locks ensure there\'s no mistake about what you\'re wearing. And for a little extra luck, number 23 is embroidered on the outer heel for some GOAT-given good fortune.\r\n', NULL, 17499.00, 250, 2, '8,9,10', 'green', NULL, '2024-11-16 13:20:48', '2024-11-16 13:20:48'),
(26, 'Nike SB React Leo', 'Luxury and utility come together in this genderless collaboration with Leo Baker. Designed for effortless skating with next-level accuracy, these shoes come perfectly broken in for a longer consistent performance. Tested by Leo, designed for you.\r\n', NULL, 8149.00, 250, 2, '8,9', 'white', NULL, '2024-11-16 13:22:14', '2024-11-16 13:22:14'),
(27, 'Air Jordan 1 Low SE', 'Show love to your furry friends in this special edition AJ1. Keeping the clean and classic look inspired by the \'85 original, it features textured laces and paw prints on the outsole for a fresh take on an all-time favourite.\r\n', NULL, 11500.00, 350, 2, '8,9', 'pink', NULL, '2024-11-16 13:23:16', '2024-11-16 13:23:16'),
(28, 'Air Jordan 1 Elevate Low', 'Rise to the occasion in style that soars. This shoe reworks an icon\'s original magic with a platform sole and low-cut silhouette. Air cushioning keeps you lifted, and sleek leather in contrasting colours adds visual interest.\r\n', NULL, 11999.00, 245, 2, '8,9,10', 'blue', NULL, '2024-11-16 13:24:17', '2024-11-18 06:24:00'),
(29, 'Nike Air Force 1 \'07 Essential', 'Classic, crisp, comfortable—that\'s the Air Force 1 \'07 Essential. These sneakers put a fresh spin on a hoops icon with a mini embroidered Swoosh. Of course, we kept the same era-echoing \'80s construction and hidden Nike Air cushioning for that legendary AF-1 feel. Go ahead, slip into a slam dunk.\r\n', NULL, 9999.00, 299, 2, '8,9,10', 'white', NULL, '2024-11-16 13:25:30', '2024-11-18 06:21:07'),
(31, 'Nike Air Force 1 \'07', 'Comfortable, durable and timeless—it\'s number 1 for a reason. The radiance lives on with a classic \'80s construction that pairs bold details for style with a subtle platform, putting a fresh spin on an icon.\r\n', NULL, 9995.00, 200, 2, '8,9,10', 'white', NULL, '2024-12-10 16:05:09', '2024-12-10 16:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`) VALUES
(1, 1, 'pro-img/n1.1.png'),
(2, 1, 'pro-img/n1.2.png'),
(3, 1, 'pro-img/n1.3.png'),
(4, 1, 'pro-img/n1.4.png'),
(5, 1, 'pro-img/n1.png'),
(6, 2, 'pro-img/nb2.0.png'),
(7, 2, 'pro-img/nb2.1.png'),
(8, 2, 'pro-img/nb2.2.png'),
(9, 2, 'pro-img/nb2.3.png'),
(10, 2, 'pro-img/nb2.4.png'),
(11, 3, 'pro-img/nb3.0.png'),
(12, 3, 'pro-img/nb3.1.png'),
(13, 3, 'pro-img/nb3.2.jpeg'),
(14, 3, 'pro-img/nb3.3.png'),
(15, 3, 'pro-img/nb3.4.png'),
(16, 4, 'pro-img/ng4.0.jpeg'),
(17, 4, 'pro-img/ng4.1.jpeg'),
(18, 4, 'pro-img/ng4.2.jpeg'),
(19, 4, 'pro-img/ng4.3.jpeg'),
(20, 4, 'pro-img/ng4.4.jpeg'),
(21, 5, 'pro-img/nb5.0.png'),
(22, 5, 'pro-img/nb5.1.png'),
(23, 5, 'pro-img/nb5.2.png'),
(24, 5, 'pro-img/nb5.3.png'),
(25, 5, 'pro-img/nb5.4.png'),
(26, 6, 'pro-img/nb6.0.jpeg'),
(27, 6, 'pro-img/nb6.1.png'),
(28, 6, 'pro-img/nb6.2.png'),
(29, 6, 'pro-img/nb6.3.png'),
(30, 6, 'pro-img/nb6.4.png'),
(31, 7, 'pro-img/nb7.0.png'),
(32, 7, 'pro-img/nb7.1.png'),
(33, 7, 'pro-img/nb7.2.png'),
(34, 7, 'pro-img/nb7.3.png'),
(35, 7, 'pro-img/nb7.4.png'),
(36, 8, 'pro-img/nw8.0.png'),
(37, 8, 'pro-img/nw8.1.png'),
(38, 8, 'pro-img/nw8.2.png'),
(39, 8, 'pro-img/nw8.3.png'),
(40, 8, 'pro-img/nw8.4.png'),
(41, 9, 'pro-img/no9.0.png'),
(42, 9, 'pro-img/no9.1.png'),
(43, 9, 'pro-img/no9.2.png'),
(44, 9, 'pro-img/no9.3.png'),
(45, 9, 'pro-img/no9.4.png'),
(46, 10, 'pro-img/nw10.0.jpeg'),
(47, 10, 'pro-img/nw10.1.jpeg'),
(48, 10, 'pro-img/nw10.2.jpeg'),
(49, 10, 'pro-img/nw10.3.jpeg'),
(50, 10, 'pro-img/nw10.4.jpeg'),
(51, 11, 'pro-img/nb11.0.jpeg'),
(52, 11, 'pro-img/nb11.1.png'),
(53, 11, 'pro-img/nb11.2.jpeg'),
(54, 11, 'pro-img/nb11.3.png'),
(55, 11, 'pro-img/nb11.4.jpeg'),
(56, 12, 'pro-img/ng12.0.jpeg'),
(57, 12, 'pro-img/ng12.1.png'),
(58, 12, 'pro-img/ng12.2.png'),
(59, 12, 'pro-img/ng12.3.png'),
(60, 12, 'pro-img/ng12.4.png'),
(61, 13, 'pro-img/nw13.0.jpeg'),
(62, 13, 'pro-img/nw13.1.jpeg'),
(63, 13, 'pro-img/nw13.2.jpeg'),
(64, 13, 'pro-img/nw13.3.jpeg'),
(65, 13, 'pro-img/nw13.4.jpeg'),
(66, 14, 'pro-img/nb14.0.png'),
(67, 14, 'pro-img/nb14.1.png'),
(68, 14, 'pro-img/nb14.2.jpeg'),
(69, 14, 'pro-img/nb14.3.png'),
(70, 14, 'pro-img/nb14.4.jpeg'),
(71, 15, 'pro-img/ng15.0.jpeg'),
(72, 15, 'pro-img/ng15.1.png'),
(73, 15, 'pro-img/ng15.2.jpeg'),
(74, 15, 'pro-img/ng15.3.png'),
(75, 15, 'pro-img/ng15.4.png'),
(76, 16, 'pro-img/ns1.0.png'),
(77, 16, 'pro-img/ns1.1.png'),
(78, 16, 'pro-img/ns1.2.png'),
(79, 16, 'pro-img/ns1.3.png'),
(80, 16, 'pro-img/ns1.4.png'),
(81, 17, 'pro-img/ny2.0.png'),
(82, 17, 'pro-img/ny2.1.png'),
(83, 17, 'pro-img/ny2.2.png'),
(84, 17, 'pro-img/ny2.3.png'),
(85, 17, 'pro-img/ny2.4.png'),
(86, 18, 'pro-img/nw3.0.png'),
(87, 18, 'pro-img/nw3.1.png'),
(88, 18, 'pro-img/nw3.2.png'),
(89, 18, 'pro-img/nw3.3.png'),
(90, 18, 'pro-img/nw3.4.png'),
(91, 19, 'pro-img/np4.0.png'),
(92, 19, 'pro-img/np4.1.png'),
(93, 19, 'pro-img/np4.2.png'),
(94, 19, 'pro-img/np4.3.png'),
(95, 19, 'pro-img/np4.4.png'),
(96, 20, 'pro-img/ng5.0.png'),
(97, 20, 'pro-img/ng5.1.png'),
(98, 20, 'pro-img/ng5.2.png'),
(99, 20, 'pro-img/ng5.3.png'),
(100, 20, 'pro-img/ng5.4.png'),
(101, 21, 'pro-img/ng6.0.jpeg'),
(102, 21, 'pro-img/ng6.1.jpeg'),
(103, 21, 'pro-img/ng6.2.jpeg'),
(104, 21, 'pro-img/ng6.3.png'),
(105, 21, 'pro-img/ng6.4.png'),
(106, 22, 'pro-img/nb7.0.png'),
(107, 22, 'pro-img/nb7.1.png'),
(108, 22, 'pro-img/nb7.2.png'),
(109, 22, 'pro-img/nb7.3.png'),
(110, 22, 'pro-img/nb7.4.png'),
(111, 23, 'pro-img/ng8.0.png'),
(112, 23, 'pro-img/ng8.1.png'),
(113, 23, 'pro-img/ng8.2.jpeg'),
(114, 23, 'pro-img/ng8.3.png'),
(115, 23, 'pro-img/ng8.4.png'),
(116, 24, 'pro-img/ng9.0.jpeg'),
(117, 24, 'pro-img/ng9.1.jpeg'),
(118, 24, 'pro-img/ng9.2.png'),
(119, 24, 'pro-img/ng9.3.png'),
(120, 24, 'pro-img/ng9.4.png'),
(121, 25, 'pro-img/nw10.0.png'),
(122, 25, 'pro-img/nw10.1.png'),
(123, 25, 'pro-img/nw10.2.png'),
(124, 25, 'pro-img/nw10.3.png'),
(125, 25, 'pro-img/nw10.4.png'),
(126, 26, 'pro-img/nw11.0.png'),
(127, 26, 'pro-img/nw11.1.png'),
(128, 26, 'pro-img/nw11.2.png'),
(129, 26, 'pro-img/nw11.3.png'),
(130, 26, 'pro-img/nw11.4.png'),
(131, 27, 'pro-img/np12.0.png'),
(132, 27, 'pro-img/np12.1.png'),
(133, 27, 'pro-img/np12.2.png'),
(134, 27, 'pro-img/np12.3.png'),
(135, 27, 'pro-img/np12.4.png'),
(136, 28, 'pro-img/nb13.0.png'),
(137, 28, 'pro-img/nb13.1.png'),
(138, 28, 'pro-img/nb13.2.png'),
(139, 28, 'pro-img/nb13.3.png'),
(140, 28, 'pro-img/nb13.4.png'),
(141, 29, 'pro-img/nw14.0.png'),
(142, 29, 'pro-img/nw14.1.png'),
(143, 29, 'pro-img/nw14.2.png'),
(144, 29, 'pro-img/nw14.3.png'),
(145, 29, 'pro-img/nw14.4.png'),
(151, 31, 'pro-img/nb15.0.png'),
(152, 31, 'pro-img/nb15.1.png'),
(153, 31, 'pro-img/nb15.2.png'),
(154, 31, 'pro-img/nb15.3.png'),
(155, 31, 'pro-img/nb15.4.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 2, 2, 5, 'Best', '2024-11-17 21:22:25'),
(2, 28, 2, 5, 'This shoes is Best shoes I love this Prodoct', '2024-11-18 06:23:30'),
(3, 2, 3, 4, 'This shoes Is Superb and I Like This Product', '2024-11-18 08:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` int(10) NOT NULL,
  `color` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resettoken` varchar(255) DEFAULT NULL,
  `resettokenexpired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `address`, `created_at`, `resettoken`, `resettokenexpired`) VALUES
(1, 'meet', 'malvaniya', 'bhavsarmeet2018@gmail.com', '$2y$10$W2YAZGVHgeHXdXZKtwj20OEm6dBYJgTxYOuOId7cvIiAQVV5NcSF6', NULL, NULL, '2024-11-08 10:06:17', '', NULL),
(2, 'kavan', 'vadecha', 'kavan@gmail.com', '$2y$10$B1eKUvuRKP/CSHpSXAMauu7w7pk.HfVmvhdfmSTPYPTW1O83Kkev.', NULL, NULL, '2024-11-15 05:38:15', '', NULL),
(3, 'divypal', 'zala', 'zala@gmail.com', '$2y$10$FW7X6ULc9X.Vc1hixIwSXe6bokKQNF2Hkw6udlppZegW.PUgQV9Re', '7812457812', 'bciabsscbbc', '2024-11-15 05:49:40', '', NULL),
(4, 'Krunal', 'Vegada', 'vegdakrunal21@gmail.com', '$2y$10$hEWIyHvL420MMOvbQ7GEpeFrBEviiRtbb4Dk/uox8vKDlrno5dq3q', '9879812435', 'Dhandhuka', '2024-11-18 10:59:26', '58895b1d721ab3d84d9bd7551112df39', '2024-11-18'),
(5, 'Saraiya', 'Jainam', 'jainamsaraiya9@gmail.com', '$2y$10$N3M7uUbPJWHkpmM11GT45.aDLDfOx8yyD0i7Gr9MsbHdOeFnIoRa2', '9275025835', '80 feet road Surendranagar', '2024-11-18 12:55:25', NULL, NULL),
(6, 'NIkul', 'Hirani', 'hiraninikul222@gmail.com', '$2y$10$6jSoHIdwSY04.dGdwqwnwuJYVxNXW9FkARWNDgIWiO8kwuBV6.WHm', '8153882575', 'Limbdi', '2024-11-23 15:35:12', '7ecab5252a4b5f64002d46135f2756af', '2024-11-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
