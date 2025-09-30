-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2021 at 07:00 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xa_grants_management_2021`
--

-- --------------------------------------------------------

--
-- Table structure for table `ppr_appeal_halted_studies`
--

CREATE TABLE `ppr_appeal_halted_studies` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `halted_by` int(11) NOT NULL,
  `reasonsforhalting` text NOT NULL,
  `appealReason` text NOT NULL,
  `dateHaulted` varchar(50) NOT NULL,
  `status` enum('Pending','Appeal Accepted','Appealled') NOT NULL DEFAULT 'Pending',
  `reasonAfterReview` text NOT NULL,
  `reviewedOn` varchar(50) NOT NULL,
  `appealSubmitted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `appealDate` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_categories`
--

CREATE TABLE `ppr_categories` (
  `rstug_categoryID` int(255) NOT NULL,
  `rstug_categoryName` varchar(255) NOT NULL,
  `rstugshort1` varchar(50) NOT NULL,
  `rstugshort2` varchar(50) NOT NULL,
  `rstugNo` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_categories`
--

INSERT INTO `ppr_categories` (`rstug_categoryID`, `rstug_categoryName`, `rstugshort1`, `rstugshort2`, `rstugNo`) VALUES
(1, 'Medical and Health Sciences', 'HS', 'ES', 0),
(2, 'Social Science', 'SS', 'ES', 0),
(3, 'Natural Sciences', 'NS', 'ES', 0),
(5, 'Agricultural Sciences', 'A', 'ES', 0),
(6, 'Engineering and Technology', 'SIR', 'ES', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ppr_concepts`
--

CREATE TABLE `ppr_concepts` (
  `conceptm_id` int(255) NOT NULL,
  `usrm_id` int(255) NOT NULL,
  `ms_NameOfPI` varchar(255) NOT NULL,
  `conceptm_NameofInstitution` varchar(255) NOT NULL,
  `conceptm_email` varchar(255) NOT NULL,
  `conceptm_phone` varchar(100) NOT NULL,
  `proposalmTittle` varchar(255) NOT NULL,
  `cpt_sector` varchar(100) NOT NULL,
  `cpt_othersector` varchar(255) NOT NULL,
  `proposalm_upload` varchar(255) NOT NULL,
  `referenceno` varchar(100) NOT NULL,
  `conceptm_date` datetime NOT NULL,
  `conceptm_status` enum('new','approved','reviewed','rejected','forwaded','completed','evaluated','pending') NOT NULL,
  `conceptm_cmtapprove` text NOT NULL,
  `conceptm_cmtreject` text NOT NULL,
  `conceptm_assignedto` int(255) NOT NULL,
  `conceptm_assignedby` int(255) NOT NULL,
  `proposalm_uploadReup` varchar(255) NOT NULL,
  `conceptm_Reviewers` int(11) NOT NULL,
  `conceptm_Avg` int(11) NOT NULL,
  `conceptm_Times` int(11) NOT NULL,
  `categorym` enum('concepts','proposals') NOT NULL,
  `sentNotify` enum('No','Yes','Failed') NOT NULL DEFAULT 'No',
  `mailtext` longtext NOT NULL,
  `openstatus` enum('open','closed') NOT NULL DEFAULT 'open',
  `proposal_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_conceptsasslogs`
--

CREATE TABLE `ppr_conceptsasslogs` (
  `assignm_id` int(255) NOT NULL,
  `conceptm_id` int(255) NOT NULL,
  `conceptm_assignedto` int(255) NOT NULL,
  `conceptm_by` int(255) NOT NULL,
  `assignm_date` datetime NOT NULL,
  `logm_status` enum('new','completed') NOT NULL,
  `categorym` enum('concepts','proposals') NOT NULL,
  `openstatus` enum('open','closed') NOT NULL DEFAULT 'open'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_conceptsasslogs_new`
--

CREATE TABLE `ppr_conceptsasslogs_new` (
  `assignm_id` int(255) NOT NULL,
  `conceptm_id` int(255) NOT NULL,
  `conceptm_assignedto` int(255) NOT NULL,
  `conceptm_by` int(255) NOT NULL,
  `assignm_date` datetime NOT NULL,
  `logm_status` enum('new','completed') NOT NULL,
  `categorym` enum('concepts','proposals') NOT NULL,
  `openstatus` enum('open','closed') NOT NULL DEFAULT 'open',
  `conceptm_assignedby` int(255) NOT NULL,
  `conflictofInterest` enum('No','Yes','none') NOT NULL DEFAULT 'none',
  `availableReview` enum('no','yes') NOT NULL DEFAULT 'no',
  `availableReviewComment` text NOT NULL,
  `reviewStatus` enum('static','dynamic') NOT NULL DEFAULT 'static'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_conceptsasslogs_new`
--

INSERT INTO `ppr_conceptsasslogs_new` (`assignm_id`, `conceptm_id`, `conceptm_assignedto`, `conceptm_by`, `assignm_date`, `logm_status`, `categorym`, `openstatus`, `conceptm_assignedby`, `conflictofInterest`, `availableReview`, `availableReviewComment`, `reviewStatus`) VALUES
(1, 1, 33, 0, '2021-06-17 18:06:33', 'new', 'concepts', 'open', 112, 'none', 'no', '', 'dynamic'),
(2, 1, 35, 0, '2021-06-17 18:06:37', 'new', 'concepts', 'open', 112, 'none', 'no', '', 'dynamic'),
(3, 1, 172, 0, '2021-06-17 18:06:42', 'new', 'concepts', 'open', 112, 'No', 'yes', '', 'dynamic');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_concepts_cvs`
--

CREATE TABLE `ppr_concepts_cvs` (
  `cvID` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `usrm_id` int(255) NOT NULL,
  `cvname` varchar(255) NOT NULL,
  `cvdate` datetime NOT NULL,
  `openstatus` enum('open','closed') NOT NULL DEFAULT 'open',
  `conceptm_id` int(11) NOT NULL,
  `proposal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_concepts_dates`
--

CREATE TABLE `ppr_concepts_dates` (
  `dateID` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_concept_attachments`
--

CREATE TABLE `ppr_concept_attachments` (
  `id` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `filename` text NOT NULL,
  `updated` varchar(50) NOT NULL,
  `attachmentCategory` enum('concept','proposal','cv','workplan','budget','other') NOT NULL DEFAULT 'other',
  `is_sent` int(11) NOT NULL,
  `catNormal` enum('static','dynamic') NOT NULL DEFAULT 'static'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_concept_attachments`
--

INSERT INTO `ppr_concept_attachments` (`id`, `conceptID`, `owner_id`, `filename`, `updated`, `attachmentCategory`, `is_sent`, `catNormal`) VALUES
(1, 1, 287, '287RM_assignment_2.pdf', '2021-06-17 15:18:46', 'budget', 0, 'dynamic'),
(2, 1, 287, '28712BabyGelCRFSAEV10_BabyGelProj_2021-03-13_1737.pdf', '2021-06-17 15:54:26', 'workplan', 0, 'dynamic'),
(3, 1, 287, '287resuscitation_safri.ac.pdf', '2021-06-17 15:55:17', '', 0, 'dynamic'),
(4, 1, 287, '287Company-Form-18.pdf', '2021-06-17 15:56:05', '', 0, 'dynamic');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_concept_budget`
--

CREATE TABLE `ppr_concept_budget` (
  `id` int(11) NOT NULL,
  `Personnel` double NOT NULL,
  `PersonnelTotal` double NOT NULL,
  `ResearchCosts` double NOT NULL,
  `ResearchCostsTotal` double NOT NULL,
  `Equipment` double NOT NULL,
  `EquipmentTotal` double NOT NULL,
  `kickoff` double NOT NULL,
  `kickoffTotal` double NOT NULL,
  `Travel` double NOT NULL,
  `TravelTotal` double NOT NULL,
  `KnowledgeSharing` double NOT NULL,
  `KnowledgeSharingTotal` double NOT NULL,
  `OverheadCosts` double NOT NULL,
  `OverheadCostsTotal` double NOT NULL,
  `OtherGoods` double NOT NULL,
  `OtherGoodsTotal` double NOT NULL,
  `MatchingSupport` double NOT NULL,
  `MatchingSupportTotal` double NOT NULL,
  `TotalBudget` double NOT NULL,
  `TotalSubmitted` double NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_concept_references`
--

CREATE TABLE `ppr_concept_references` (
  `id` int(255) NOT NULL,
  `creferences` longtext NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_concept_stages`
--

CREATE TABLE `ppr_concept_stages` (
  `id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `ProjectInformation` int(11) NOT NULL,
  `PrincipalInvestigator` int(11) NOT NULL,
  `Introduction` int(11) NOT NULL,
  `ProjectDetails` int(11) NOT NULL,
  `Budget` int(11) NOT NULL,
  `cReferences` int(11) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `PrincipalInvestigatorEducation` int(11) NOT NULL,
  `PrincipalInvestigatorResearch` int(11) NOT NULL,
  `conceptAttachments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_countries`
--

CREATE TABLE `ppr_countries` (
  `cidm_country_id` int(11) NOT NULL,
  `cidm_country_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_countries`
--

INSERT INTO `ppr_countries` (`cidm_country_id`, `cidm_country_name`) VALUES
(1, 'Germany'),
(2, 'USA'),
(3, 'Uganda'),
(4, 'Kenya'),
(5, 'Switzerland'),
(6, 'France'),
(7, 'Egypt'),
(8, 'Rwanda'),
(9, 'Canada'),
(10, 'Slovakia'),
(11, 'Slovenia'),
(12, 'Solomon Islands'),
(13, 'South Africa'),
(14, 'South Korea'),
(15, 'South Sudan'),
(16, 'Spain'),
(17, 'Sri Lanka'),
(18, 'Sweden'),
(19, 'Saudi Arabia'),
(20, 'Serbia'),
(21, 'Singapore'),
(22, 'Albania'),
(23, 'Argentina'),
(24, 'Australia'),
(25, 'Austria'),
(26, 'Azerbaijan'),
(27, 'Bangladesh'),
(28, 'Barbados'),
(29, 'Belgium'),
(30, 'Belarus'),
(31, 'Bolivia'),
(32, 'Bosnia and Herzegovina'),
(33, 'Brazil'),
(34, 'Burkina Faso'),
(35, 'Chile'),
(36, 'China'),
(37, 'Colombia'),
(38, 'Comoros'),
(39, 'Costa Rica'),
(40, 'Cote d\'Ivoire'),
(41, 'Croatia'),
(42, 'Cuba'),
(43, 'Cyprus'),
(44, 'Czech Republic'),
(45, 'Denmark'),
(46, 'Dominica'),
(47, 'Ecuador'),
(48, 'Ethiopia'),
(49, 'Fiji'),
(50, 'Finland'),
(51, 'Guyana'),
(52, 'Haiti'),
(53, 'Honduras'),
(54, 'Hong Kong'),
(55, 'Hungary'),
(56, 'Iceland'),
(57, 'India'),
(58, 'Indonesia'),
(59, 'Iran'),
(60, 'Iraq'),
(61, 'Ireland'),
(62, 'Israel'),
(63, 'Italy'),
(64, 'Jamaica'),
(65, 'Japan'),
(66, 'Jordan'),
(67, 'Kazakhstan'),
(68, 'Kiribati'),
(69, 'North Korea'),
(70, 'Kuwait'),
(71, 'Lebanon'),
(72, 'Lesotho'),
(73, 'Libya'),
(74, 'Luxembourg'),
(75, 'Madagascar'),
(76, 'Macedonia'),
(77, 'Malaysia'),
(78, 'Marshall Islands'),
(79, 'Malta'),
(80, 'Mauritania'),
(81, 'Mauritius'),
(82, 'Mexico'),
(83, 'Moldova'),
(84, 'Monaco'),
(85, 'Mongolia'),
(86, 'Montenegro'),
(87, 'Morocco'),
(88, 'Mozambique'),
(89, 'Nepal'),
(90, 'Netherlands'),
(91, 'Norway'),
(92, 'Oman'),
(93, 'Pakistan'),
(94, 'Panama'),
(95, 'Paraguay'),
(96, 'Peru'),
(97, 'Philippines'),
(98, 'Poland'),
(99, 'Portugal'),
(100, 'Qatar'),
(101, 'Romania'),
(102, 'Russia'),
(103, 'Taiwan'),
(104, 'Tajikistan'),
(105, 'Thailand'),
(106, 'Trinidad and Tobago'),
(107, 'Turkey'),
(108, 'Turkmenistan'),
(109, 'Ukraine'),
(110, 'United Arab Emirates'),
(111, 'United Kingdom'),
(112, 'Uruguay'),
(113, 'Uzbekistan'),
(114, 'Venezuela'),
(115, 'Vietnam'),
(116, 'Yemen'),
(117, 'Zimbabwe'),
(118, 'Zambia'),
(119, 'Tanzania');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_currency`
--

CREATE TABLE `ppr_currency` (
  `currencyID` int(11) NOT NULL,
  `currency` varchar(20) NOT NULL,
  `symbol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_currency`
--

INSERT INTO `ppr_currency` (`currencyID`, `currency`, `symbol`) VALUES
(1, 'UGX', '/='),
(2, 'USD', '$'),
(3, 'EUR', '€'),
(4, 'GBP', '£'),
(5, 'JPY', '¥'),
(6, 'AUD', 'A$'),
(7, 'CAD', 'C$'),
(8, 'CHF', 'CHF'),
(9, 'HKD', 'HK$'),
(10, 'KRW', '?'),
(11, 'INR', '?'),
(12, 'ZAR', 'R'),
(13, 'ZMW', 'ZMW'),
(14, 'NGN', 'NGN'),
(15, 'KES', ''),
(16, 'TZS', ''),
(17, 'TND', ''),
(18, 'AOA', ''),
(19, 'EGP', '');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_duration`
--

CREATE TABLE `ppr_duration` (
  `durationID` int(11) NOT NULL,
  `yearID` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `durationdesc` varchar(20) NOT NULL DEFAULT 'Months'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_duration`
--

INSERT INTO `ppr_duration` (`durationID`, `yearID`, `duration`, `durationdesc`) VALUES
(1, 1, 1, 'Month'),
(2, 1, 2, 'Months'),
(3, 1, 3, 'Months'),
(4, 1, 4, 'Months'),
(5, 1, 5, 'Months'),
(6, 1, 6, 'Months'),
(7, 1, 7, 'Months'),
(8, 1, 8, 'Months'),
(9, 1, 9, 'Months'),
(10, 1, 10, 'Months'),
(11, 1, 11, 'Months'),
(12, 1, 12, 'Months'),
(13, 2, 13, 'Months'),
(14, 2, 14, 'Months'),
(15, 2, 15, 'Months'),
(16, 2, 16, 'Months'),
(17, 2, 17, 'Months'),
(18, 2, 18, 'Months'),
(19, 2, 19, 'Months'),
(20, 2, 20, 'Months'),
(21, 2, 21, 'Months'),
(22, 2, 22, 'Months'),
(23, 2, 23, 'Months'),
(24, 2, 24, 'Months'),
(25, 3, 25, 'Months'),
(26, 3, 26, 'Months'),
(27, 3, 27, 'Months'),
(28, 3, 28, 'Months'),
(29, 3, 29, 'Months'),
(30, 3, 30, 'Months'),
(31, 3, 31, 'Months'),
(32, 3, 32, 'Months'),
(33, 3, 33, 'Months'),
(34, 3, 34, 'Months'),
(35, 3, 35, 'Months'),
(36, 3, 36, 'Months'),
(37, 4, 37, 'Months'),
(38, 4, 38, 'Months'),
(39, 4, 39, 'Months'),
(40, 4, 40, 'Months'),
(41, 4, 41, 'Months'),
(42, 4, 42, 'Months'),
(43, 4, 43, 'Months'),
(44, 4, 44, 'Months'),
(45, 4, 45, 'Months'),
(46, 4, 46, 'Months'),
(47, 4, 47, 'Months'),
(48, 4, 48, 'Months'),
(49, 5, 49, 'Months'),
(50, 5, 50, 'Months'),
(51, 5, 51, 'Months'),
(52, 5, 52, 'Months'),
(53, 5, 53, 'Months'),
(54, 5, 54, 'Months'),
(55, 5, 55, 'Months'),
(56, 5, 56, 'Months'),
(57, 5, 57, 'Months'),
(58, 5, 58, 'Months'),
(59, 5, 59, 'Months'),
(60, 5, 60, 'Months');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_dynamic_budget_answers`
--

CREATE TABLE `ppr_dynamic_budget_answers` (
  `id` int(11) NOT NULL,
  `Personnel` double NOT NULL,
  `PersonnelTotal` double NOT NULL,
  `ResearchCosts` double NOT NULL,
  `ResearchCostsTotal` double NOT NULL,
  `Equipment` double NOT NULL,
  `EquipmentTotal` double NOT NULL,
  `kickoff` double NOT NULL,
  `kickoffTotal` double NOT NULL,
  `Travel` double NOT NULL,
  `TravelTotal` double NOT NULL,
  `KnowledgeSharing` double NOT NULL,
  `KnowledgeSharingTotal` double NOT NULL,
  `OverheadCosts` double NOT NULL,
  `OverheadCostsTotal` double NOT NULL,
  `OtherGoods` double NOT NULL,
  `OtherGoodsTotal` double NOT NULL,
  `MatchingSupport` double NOT NULL,
  `MatchingSupportTotal` double NOT NULL,
  `TotalBudget` double NOT NULL,
  `TotalSubmitted` double NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `initialtotalBudget` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_dynamic_budget_answers`
--

INSERT INTO `ppr_dynamic_budget_answers` (`id`, `Personnel`, `PersonnelTotal`, `ResearchCosts`, `ResearchCostsTotal`, `Equipment`, `EquipmentTotal`, `kickoff`, `kickoffTotal`, `Travel`, `TravelTotal`, `KnowledgeSharing`, `KnowledgeSharingTotal`, `OverheadCosts`, `OverheadCostsTotal`, `OtherGoods`, `OtherGoodsTotal`, `MatchingSupport`, `MatchingSupportTotal`, `TotalBudget`, `TotalSubmitted`, `owner_id`, `projectCategory`, `is_sent`, `conceptID`, `initialtotalBudget`) VALUES
(1, 700, 720, 5400, 5400, 1350, 1350, 180, 180, 180, 0, 450, 450, 450, 450, 180, 180, 90, 0, 0, 9000, 287, 'Project', 0, 1, '9000');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_dynamic_categories_main`
--

CREATE TABLE `ppr_dynamic_categories_main` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_rank` int(11) NOT NULL,
  `published` enum('No','Yes') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ppr_dynamic_categories_main`
--

INSERT INTO `ppr_dynamic_categories_main` (`category_id`, `category_name`, `category_rank`, `published`) VALUES
(1, 'Project Information', 1, 'Yes'),
(2, 'Project Team', 2, 'Yes'),
(3, 'Introduction', 3, 'Yes'),
(4, 'Project Details', 4, 'Yes'),
(5, 'Budget', 5, 'Yes'),
(6, 'Citations', 6, 'Yes'),
(7, 'Attachments', 7, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_dynamic_concept_stages`
--

CREATE TABLE `ppr_dynamic_concept_stages` (
  `id` int(255) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `grantID` int(255) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `dconceptID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_dynamic_concept_stages`
--

INSERT INTO `ppr_dynamic_concept_stages` (`id`, `categoryID`, `owner_id`, `status`, `grantID`, `is_sent`, `dconceptID`) VALUES
(1, 1, 287, 'completed', 1, 1, 1),
(3, 2, 287, 'completed', 1, 1, 0),
(4, 3, 287, 'completed', 1, 1, 0),
(5, 4, 287, 'completed', 1, 1, 0),
(6, 5, 287, 'completed', 1, 1, 0),
(7, 6, 287, 'completed', 1, 1, 0),
(9, 7, 287, 'completed', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ppr_dynamic_concept_titles`
--

CREATE TABLE `ppr_dynamic_concept_titles` (
  `dconceptID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `grantID` int(255) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `referenceNo` varchar(255) NOT NULL,
  `projectStatus` enum('Pending Final Submission','Pending Review','Approved','Rejected','Scheduled for Review','Reviewed') NOT NULL DEFAULT 'Pending Final Submission',
  `finalSubmission` enum('Made Final Submission','Pending Final Submission') NOT NULL DEFAULT 'Pending Final Submission',
  `dateUpdated` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `categoryID` int(255) NOT NULL,
  `rejectComents` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_dynamic_concept_titles`
--

INSERT INTO `ppr_dynamic_concept_titles` (`dconceptID`, `owner_id`, `grantID`, `project_title`, `referenceNo`, `projectStatus`, `finalSubmission`, `dateUpdated`, `is_sent`, `categoryID`, `rejectComents`) VALUES
(1, 287, 1, 'The Covid effect Pandemic', 'COV202101', 'Approved', 'Made Final Submission', '2021-06-17 14:56:05', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_dynamic_proposal_stages`
--

CREATE TABLE `ppr_dynamic_proposal_stages` (
  `id` int(255) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `grantID` int(255) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `dproposalID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_dynamic_proposal_titles`
--

CREATE TABLE `ppr_dynamic_proposal_titles` (
  `dproposalID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `grantID` int(255) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `referenceNo` varchar(255) NOT NULL,
  `projectStatus` enum('Pending Final Submission','Pending Review','Approved','Rejected','Scheduled for Review','Reviewed') NOT NULL DEFAULT 'Pending Final Submission',
  `finalSubmission` enum('Made Final Submission','Pending Final Submission') NOT NULL DEFAULT 'Pending Final Submission',
  `dateUpdated` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `categoryID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_education_history`
--

CREATE TABLE `ppr_education_history` (
  `rstug_educn_id` int(255) NOT NULL,
  `rstug_user_id` int(255) NOT NULL,
  `rstug_educn_university` varchar(255) NOT NULL,
  `rstug_educn_qualification` varchar(255) NOT NULL,
  `rstug_educn_class` varchar(100) NOT NULL,
  `rstug_educn_year` int(50) NOT NULL,
  `rstug_educn_specialisation` varchar(255) NOT NULL,
  `rstug_educn_process_status` enum('Pending','Completed') NOT NULL,
  `rstug_ammend` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `piID` int(255) NOT NULL,
  `completionyear` varchar(10) NOT NULL,
  `workExperience` text NOT NULL,
  `catNormal` enum('static','dynamic') NOT NULL DEFAULT 'static'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_education_history`
--

INSERT INTO `ppr_education_history` (`rstug_educn_id`, `rstug_user_id`, `rstug_educn_university`, `rstug_educn_qualification`, `rstug_educn_class`, `rstug_educn_year`, `rstug_educn_specialisation`, `rstug_educn_process_status`, `rstug_ammend`, `conceptID`, `is_sent`, `piID`, `completionyear`, `workExperience`, `catNormal`) VALUES
(1, 287, 'Uganda Matrys Univ', 'Masters in Ethics', '', 2018, 'Management', 'Completed', 0, 0, 0, 1, '2020', '', 'dynamic'),
(2, 287, 'sdnfnsdnfsd', 'asdsfnsdf', '', 2020, 'sndfndsnfnds', 'Completed', 0, 0, 0, 2, '2020', '', 'dynamic'),
(3, 287, 'Test Test4', 'Masters in Geo', '', 2019, 'nsdnsands', 'Completed', 0, 0, 0, 3, '2021', '', 'dynamic');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcalls`
--

CREATE TABLE `ppr_grantcalls` (
  `grantID` int(11) NOT NULL,
  `title` text NOT NULL,
  `summary` text NOT NULL,
  `details` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `category` enum('concepts','grants') NOT NULL,
  `conceptID` int(11) NOT NULL,
  `shortacronym` varchar(20) NOT NULL,
  `dynamic` enum('No','Yes') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_grantcalls`
--

INSERT INTO `ppr_grantcalls` (`grantID`, `title`, `summary`, `details`, `attachment`, `startDate`, `EndDate`, `category`, `conceptID`, `shortacronym`, `dynamic`) VALUES
(1, '17th June Call for Concepts 2021 about COVID', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected ', '21061702Additions_(1).pdf', '2021-06-17', '2021-06-19', 'concepts', 0, 'COV', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_categories`
--

CREATE TABLE `ppr_grantcall_categories` (
  `categoryID` int(255) NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `categorym` enum('concept','proposal') NOT NULL DEFAULT 'concept',
  `date_added` varchar(50) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'new',
  `grantID` int(255) NOT NULL,
  `category_number` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_grantcall_categories`
--

INSERT INTO `ppr_grantcall_categories` (`categoryID`, `categoryName`, `categorym`, `date_added`, `status`, `grantID`, `category_number`) VALUES
(1, '1', 'concept', '2021-06-17 14:30:37', 'old', 1, 0),
(2, '2', 'concept', '2021-06-17 14:30:37', 'old', 1, 0),
(3, '3', 'concept', '2021-06-17 14:30:37', 'old', 1, 0),
(4, '4', 'concept', '2021-06-17 14:30:37', 'old', 1, 0),
(5, '5', 'concept', '2021-06-17 14:30:37', 'old', 1, 0),
(6, '6', 'concept', '2021-06-17 14:30:37', 'old', 1, 0),
(7, '7', 'concept', '2021-06-17 14:30:37', 'old', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_qn_answers_concept`
--

CREATE TABLE `ppr_grantcall_qn_answers_concept` (
  `answerID` int(255) NOT NULL,
  `questionID` int(255) NOT NULL,
  `categoryID` int(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `usrm_id` int(255) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'new',
  `categorym` enum('concept') NOT NULL DEFAULT 'concept',
  `grantID` int(255) NOT NULL,
  `dateupdated` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `dconceptID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_grantcall_qn_answers_concept`
--

INSERT INTO `ppr_grantcall_qn_answers_concept` (`answerID`, `questionID`, `categoryID`, `answer`, `usrm_id`, `status`, `categorym`, `grantID`, `dateupdated`, `is_sent`, `dconceptID`) VALUES
(1, 1, 1, 'The dynamics in covid 19 Management, case study of Uganda cohort', 287, 'new', 'concept', 1, '2021-06-17 14:56:06', 1, 1),
(2, 2, 1, 'COV', 287, 'new', 'concept', 1, '2021-06-17 14:56:06', 1, 1),
(3, 4, 3, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', 287, 'new', 'concept', 1, '2021-06-17 15:17:04', 1, 0),
(4, 5, 3, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', 287, 'new', 'concept', 1, '2021-06-17 15:17:04', 1, 0),
(5, 6, 4, 'Project Details. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specime', 287, 'new', 'concept', 1, '2021-06-17 15:17:34', 1, 0),
(6, 8, 6, 'Citations, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 287, 'new', 'concept', 1, '2021-06-17 15:18:26', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_qn_answers_proposal`
--

CREATE TABLE `ppr_grantcall_qn_answers_proposal` (
  `answerID` int(255) NOT NULL,
  `questionID` int(255) NOT NULL,
  `categoryID` int(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `usrm_id` int(255) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'new',
  `categorym` enum('proposal') NOT NULL DEFAULT 'proposal',
  `grantID` int(255) NOT NULL,
  `dateupdated` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `dproposalID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_questions`
--

CREATE TABLE `ppr_grantcall_questions` (
  `questionID` int(255) NOT NULL,
  `categoryID` int(255) NOT NULL,
  `questionName` varchar(255) NOT NULL,
  `updatedm` varchar(50) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'new',
  `categorym` enum('concept','proposal') NOT NULL DEFAULT 'concept',
  `grantID` int(255) NOT NULL,
  `qn_number` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_grantcall_questions`
--

INSERT INTO `ppr_grantcall_questions` (`questionID`, `categoryID`, `questionName`, `updatedm`, `status`, `categorym`, `grantID`, `qn_number`) VALUES
(1, 1, 'Project Title', '2021-06-17 14:39:46', 'old', 'concept', 1, 1),
(2, 1, 'Project Acryn', '2021-06-17 14:40:05', 'old', 'concept', 1, 1),
(3, 2, 'Please add Team Members', '2021-06-17 14:40:26', 'old', 'concept', 1, 1),
(4, 3, 'Project Summary', '2021-06-17 14:40:59', 'old', 'concept', 1, 1),
(5, 3, 'Project Details', '2021-06-17 14:41:10', 'old', 'concept', 1, 1),
(6, 4, 'Summary of Findingings', '2021-06-17 14:41:29', 'old', 'concept', 1, 1),
(7, 5, 'Provide Project Budget', '2021-06-17 14:41:53', 'old', 'concept', 1, 0),
(8, 6, 'Add Citation', '2021-06-17 14:42:16', 'old', 'concept', 1, 0),
(9, 7, 'Provide Attachments', '2021-06-17 14:43:04', 'old', 'concept', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_questions_attachments`
--

CREATE TABLE `ppr_grantcall_questions_attachments` (
  `id` int(255) NOT NULL,
  `questionID` int(255) NOT NULL,
  `dynamicaddattachments` text NOT NULL,
  `categoryID` int(255) NOT NULL,
  `grantID` int(255) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'old'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_grantcall_questions_attachments`
--

INSERT INTO `ppr_grantcall_questions_attachments` (`id`, `questionID`, `dynamicaddattachments`, `categoryID`, `grantID`, `status`) VALUES
(1, 9, 'CVs', 7, 1, 'old'),
(2, 9, 'Team', 7, 1, 'old'),
(3, 9, 'Budget', 7, 1, 'old'),
(4, 9, 'Workplan', 7, 1, 'old');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_questions_budget`
--

CREATE TABLE `ppr_grantcall_questions_budget` (
  `id` int(255) NOT NULL,
  `questionID` int(255) NOT NULL,
  `categoryID` int(255) NOT NULL,
  `grantID` int(255) NOT NULL,
  `PersonnelTotal` int(11) NOT NULL,
  `ResearchCosts` int(11) NOT NULL,
  `Equipment` int(11) NOT NULL,
  `TravelandSubsistence` int(11) NOT NULL,
  `Grantkickoff` int(11) NOT NULL,
  `KnowledgeSharing` int(11) NOT NULL,
  `Overheadcosts` int(11) NOT NULL,
  `Othergoods` int(11) NOT NULL,
  `MatchingSupport` int(11) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'old'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_grantcall_questions_budget`
--

INSERT INTO `ppr_grantcall_questions_budget` (`id`, `questionID`, `categoryID`, `grantID`, `PersonnelTotal`, `ResearchCosts`, `Equipment`, `TravelandSubsistence`, `Grantkickoff`, `KnowledgeSharing`, `Overheadcosts`, `Othergoods`, `MatchingSupport`, `status`) VALUES
(1, 7, 5, 1, 8, 60, 15, 15, 2, 5, 5, 2, 1, 'old');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_questions_checkboxes`
--

CREATE TABLE `ppr_grantcall_questions_checkboxes` (
  `id` int(255) NOT NULL,
  `questionID` int(255) NOT NULL,
  `dynamiccheckboxes` text NOT NULL,
  `categoryID` int(255) NOT NULL,
  `grantID` int(255) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'old'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_questions_dropdown`
--

CREATE TABLE `ppr_grantcall_questions_dropdown` (
  `id` int(255) NOT NULL,
  `questionID` int(255) NOT NULL,
  `dropdown_option` text NOT NULL,
  `categoryID` int(255) NOT NULL,
  `grantID` int(255) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'old'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grantcall_questions_radiobutton`
--

CREATE TABLE `ppr_grantcall_questions_radiobutton` (
  `id` int(255) NOT NULL,
  `questionID` int(255) NOT NULL,
  `dynamicradiobuttion` text NOT NULL,
  `categoryID` int(255) NOT NULL,
  `grantID` int(255) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'old'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_grants_funds`
--

CREATE TABLE `ppr_grants_funds` (
  `fundsID` int(11) NOT NULL,
  `grantID` int(11) NOT NULL,
  `ApprovedGrantTotal` varchar(255) NOT NULL,
  `BalanceonTotalBudget` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_introduction_concept`
--

CREATE TABLE `ppr_introduction_concept` (
  `id` int(11) NOT NULL,
  `Introduction` varchar(255) NOT NULL,
  `Objectives` text NOT NULL,
  `Expectedoutput` text NOT NULL,
  `Expectedoutcome` text NOT NULL,
  `Impact` text NOT NULL,
  `DescribeProjectAlignment` text NOT NULL,
  `updatedon` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `Economicimpact` text NOT NULL,
  `EnvironmentalImpact` text NOT NULL,
  `SocietalImpact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_mlogs`
--

CREATE TABLE `ppr_mlogs` (
  `lid` int(255) NOT NULL,
  `log_details` varchar(255) NOT NULL,
  `logname` varchar(255) NOT NULL,
  `logemail` varchar(255) NOT NULL,
  `logip` varchar(50) NOT NULL,
  `logdate` datetime NOT NULL,
  `proposal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_mlogs`
--

INSERT INTO `ppr_mlogs` (`lid`, `log_details`, `logname`, `logemail`, `logip`, `logdate`, `proposal_id`) VALUES
(1, 'Moses has assigned  proposal titled  to Colins', '', '', '', '2021-06-17 18:06:32', 0),
(2, 'Moses has assigned  proposal titled  to Moses', '', '', '', '2021-06-17 18:06:37', 0),
(3, 'Moses has assigned  proposal titled  to Rhona', '', '', '', '2021-06-17 18:06:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ppr_monitoring_reports`
--

CREATE TABLE `ppr_monitoring_reports` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `fileAttachment` varchar(255) NOT NULL,
  `reportDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_mscores`
--

CREATE TABLE `ppr_mscores` (
  `scoredmID` int(255) NOT NULL,
  `conceptm_id` int(255) NOT NULL,
  `STQnewMethods` varchar(20) NOT NULL,
  `STQhighQuality` varchar(20) NOT NULL,
  `STQSatisfactoryPartnership` varchar(20) NOT NULL,
  `AppPrototypeClearly` varchar(20) NOT NULL,
  `AppAddressIssues` varchar(20) NOT NULL,
  `ImpactClearlyConvincingly` varchar(20) NOT NULL,
  `ImpactGenderIssues` varchar(20) NOT NULL,
  `EvTotalScore` int(11) NOT NULL,
  `EvaluatedBy` int(11) NOT NULL,
  `DateEvaluated` datetime NOT NULL,
  `usrm_id` int(255) NOT NULL,
  `EvoverallComment` text NOT NULL,
  `EvComment1` text NOT NULL,
  `EvComment2` text NOT NULL,
  `EvComment3` text NOT NULL,
  `EvComment4` text NOT NULL,
  `EvComment5` text NOT NULL,
  `EvComment6` text NOT NULL,
  `Everdict` varchar(100) NOT NULL,
  `EVivaScore` int(11) NOT NULL,
  `EvVivaComments` text NOT NULL,
  `vivconceptStatus` varchar(11) NOT NULL,
  `EvSame` int(11) NOT NULL,
  `categorym` enum('concepts','proposals','propnone') NOT NULL,
  `EvgeneralTotal` int(11) NOT NULL,
  `openstatus` enum('open','closed') NOT NULL DEFAULT 'open',
  `Potential` varchar(20) NOT NULL,
  `Budget` varchar(20) NOT NULL,
  `EvCommentnon` text NOT NULL,
  `EvComment7` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_mscores_new`
--

CREATE TABLE `ppr_mscores_new` (
  `scoredmID` int(255) NOT NULL,
  `conceptm_id` int(255) NOT NULL,
  `STQnewMethods` varchar(20) NOT NULL,
  `STQhighQuality` varchar(20) NOT NULL,
  `STQSatisfactoryPartnership` varchar(20) NOT NULL,
  `AppPrototypeClearly` varchar(20) NOT NULL,
  `AppAddressIssues` varchar(20) NOT NULL,
  `ImpactClearlyConvincingly` varchar(20) NOT NULL,
  `ImpactGenderIssues` varchar(20) NOT NULL,
  `EvTotalScore` int(11) NOT NULL,
  `EvaluatedBy` int(11) NOT NULL,
  `DateEvaluated` datetime NOT NULL,
  `usrm_id` int(255) NOT NULL,
  `EvoverallComment` text NOT NULL,
  `EvComment1` text NOT NULL,
  `EvComment2` text NOT NULL,
  `EvComment3` text NOT NULL,
  `EvComment4` text NOT NULL,
  `EvComment5` text NOT NULL,
  `EvComment6` text NOT NULL,
  `Everdict` varchar(100) NOT NULL,
  `EVivaScore` int(11) NOT NULL,
  `EvVivaComments` text NOT NULL,
  `vivconceptStatus` varchar(11) NOT NULL,
  `EvSame` int(11) NOT NULL,
  `categorym` enum('concepts','proposals','propnone') NOT NULL,
  `EvgeneralTotal` int(11) NOT NULL,
  `openstatus` enum('open','closed') NOT NULL DEFAULT 'open',
  `Potential` varchar(20) NOT NULL,
  `Budget` varchar(20) NOT NULL,
  `EvCommentnon` text NOT NULL,
  `EvComment7` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_musers`
--

CREATE TABLE `ppr_musers` (
  `usrm_id` int(10) UNSIGNED NOT NULL,
  `usrm_username` varchar(100) NOT NULL,
  `usrm_NameofInstitution` varchar(255) NOT NULL,
  `usrm_fname` varchar(100) NOT NULL,
  `usrm_sname` varchar(255) NOT NULL,
  `usrm_Nationality` int(11) NOT NULL,
  `usrm_password` varchar(100) NOT NULL,
  `usrm_phone` varchar(100) DEFAULT NULL,
  `usrm_email` varchar(100) DEFAULT NULL,
  `usrm_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usrm_approved` tinyint(1) NOT NULL DEFAULT 1,
  `usrm_usrtype` enum('user','admin','superadmin','reviewer') NOT NULL,
  `usrm_profilepic` varchar(255) NOT NULL,
  `usrm_no` varchar(255) NOT NULL,
  `usrm_gender` varchar(11) NOT NULL,
  `usrm_Qualification` varchar(255) NOT NULL,
  `usrm_dob` date NOT NULL,
  `sentNotify` enum('No','Yes','Failed') NOT NULL DEFAULT 'No',
  `categoryID` varchar(30) NOT NULL,
  `availableReview` enum('notknown','no','yes') NOT NULL DEFAULT 'notknown',
  `availableReviewComment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_musers`
--

INSERT INTO `ppr_musers` (`usrm_id`, `usrm_username`, `usrm_NameofInstitution`, `usrm_fname`, `usrm_sname`, `usrm_Nationality`, `usrm_password`, `usrm_phone`, `usrm_email`, `usrm_updated`, `usrm_approved`, `usrm_usrtype`, `usrm_profilepic`, `usrm_no`, `usrm_gender`, `usrm_Qualification`, `usrm_dob`, `sentNotify`, `categoryID`, `availableReview`, `availableReviewComment`) VALUES
(10, 'mawandammoses@gmail.com', 'Infinity Computers', 'Moses', 'Mawanda', 37, '564a1c11e08953fe822d27bd5da9c32f', '256782086452', 'mawandammoses@gmail.com', '2019-03-04 07:44:50', 1, 'user', 'avatar.jpg', '564a1c11e08953fe822d27bd5da9c32f', 'Male', 'Master\'s Degree', '1984-09-28', 'No', '', 'notknown', ''),
(19, 'Muganga L 86', 'National Coffee Research Institute', 'Lawrence ', 'Muganga', 3, '43ed95ca5874d20670a054bef6869391', '+256774594087', 'lawrmuganga@yahoo.com', '2018-05-30 12:01:00', 1, 'user', '', '94155c731b36692510d6ac0d98c92641', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(3, 'mcollins', 'Kampala-UNCST', 'JK', 'Mwesigwa', 3, 'a7c4ad37b7bbefe9fd7378f542ddefcc', '+256752807890', 'mwesigwa.collins@gmail.com', '2021-02-20 09:52:12', 1, 'superadmin', '', '8cba3da147282ed7aadc39529827b884', 'Male', 'Master\'s Degree', '1984-11-18', 'No', '', 'notknown', ''),
(18, 'hakimwanume', 'KYAMBOGO university', 'hakim', 'wanume', 3, '7acf8e3a67688fb83004cee8b91f4787', '0772908456', 'hakimwanume@yahoo.com', '2018-05-26 14:44:36', 1, 'user', '', '965d829a475010f36e232fc249106a3e', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(16, 'Babugura', 'Kabale University', 'Allen', 'Babugura', 3, '6bba35dc122e237143b8611c9c48e809', '+256777131608', 'ababugura@kab.ac.ug', '2018-05-28 01:55:31', 1, 'user', '', 'c8026ec00b9874a790983c2fa9c25f00', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(17, 'tuLe Mashariki', 'tuLe Mashariki', 'Ancel', 'Bwire', 4, 'bfe8f9fbcdb7ca2918d2d28f0c5eb3b0', '+256784667725', 'tulemashariki@gmail.com', '2018-05-28 03:46:35', 1, 'user', '', '', 'Male', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(112, 'mmawanda', 'UNCTS1', 'Moses', 'Mawanda', 3, '276aec013276b8feff9040b8d0c9f17f', '0782086452', 'mmawanda@mrsoftconsults.com', '2020-10-11 12:36:15', 1, 'superadmin', '', '5fcabb73d9c0e13dca126cbea7d8226d', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(14, 'JKL', 'Kampala-UNCST', 'James', 'JK', 33, '2ac9cb7dc02b3c0083eb70898e549b63', '0752807890', 'cmwesigwa@ifrontiers.net', '2018-05-16 10:22:17', 1, 'user', '', 'b022fb2520a804cae6ac98979693a259', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(13, 'faisal', 'UNCST', 'Faisal', 'Kiranda', 3, 'f4668288fdbf9773dd9779d412942905', '0752808452', 'mmawanda@mrsoftconsults.com', '2019-09-02 14:03:30', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(20, 'Amulen', 'College of Veterinary medicine, animal resources and biosecurity, School of Veterinary Medicine,  Research centre for', 'Deborah Ruth', 'Amulen', 3, 'cc9a5476d29864a1be6f86f898c3ddbb', '+256782315636', 'amulendeborah@gmail.com', '2018-05-31 15:57:00', 1, 'user', 'nstip_picture amulen.jpg', '6426510e9ab6849130429511ae50983e', 'Female', 'PHD', '1982-11-21', 'No', '', 'notknown', ''),
(21, 'inb', '', 'Ismail Barugahara', '', 0, '2dc398408a3742f6ca2090dfe0748868', '0414705500', 'i.barugahara@uncst.go.ug', '2019-08-28 13:55:31', 1, 'admin', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(22, 'mbolo', '', 'Maurice Bolo ', '', 0, '2c13fb2e32aa295806d781b26b79c3d3', '000254 733 670 979 ', 'Bolo@scinnovent.org', '2019-08-28 13:56:30', 1, 'admin', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(23, 'RCRAUganda', 'Director of Rwenzori Centre for Research and Advocacy', 'Jostas', 'Mwebembezi', 3, 'f6bc4e730de6c872807894d8bc5c21b1', '+256 774 553595', 'RCRAUganda2018@gmail.com', '2018-06-12 13:48:54', 1, 'user', '', '175c225a16c095b646d3b7d9fdc56575', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(24, 'jbomony', 'Uganda Industrial Research Institute (UIRI)', 'Omony ', 'John Bosco', 3, 'e40a4141adc3dce866dba7a6ada7bf11', '+256777070744', 'jbomony@yahoo.co.uk', '2018-06-13 12:21:00', 0, 'user', '', 'e4e2953aff7362c294524ab37fd2f483', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(25, 'ckmuyanja', 'MAKERERE  UNIVERITY, DEPART OF  FOOD TECHNOLOGY ANF  NUTRITION', 'charles', 'Muyanja', 3, 'ef8727d0ce4a74823d14f7f40171537e', '+256772577708/777568393', 'ckmuyanja@caes.mak.ac.ug', '2018-06-16 12:14:35', 1, 'user', '', 'b9d19bbfcc9b169e756228670ab726e1', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(26, 'collins', 'Kampala-UNCST', 'Collins', 'Mwesigwa', 3, '7d5c62a4470e0ac0015321f8aca7b6af', '256752807890', 'mwesigwa.collins@gmail.com', '2021-02-20 09:52:12', 1, 'user', '', '8cba3da147282ed7aadc39529827b884', '', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(27, 'dwendiro@gmail.com', 'Uganda Industrial Research Institute', 'DEBORAH ', 'WENDIRO', 3, 'd4c55ac470f670d423dc331151ec6f88', '+256755464502', 'dwendiro@gmail.com', '2018-07-09 13:02:54', 1, 'user', '', '', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(28, 'Ronald', '', 'Ronald Jaggwe', '', 0, '6eefa57e7671f3ac1bc57e6b2573dfe4', '0782504661', 'r.jaggwe@uncst.go.ug', '2019-08-28 13:55:01', 1, 'admin', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(29, 'Dorothy', 'Makerere UNiversity', 'Dr Dorothy', ' Okello (PhD)', 3, '08b7593cde74530e1db316e201363219', '+256772957550', 'dorothy.okello@gmail.com', '2021-06-17 13:09:11', 1, 'reviewer', '', '', 'Male', 'PHD', '1998-06-06', 'No', '3,', 'notknown', ''),
(30, 'Dick', 'UIRI', 'Dr. Dick M. ', 'Kamugasha (PhD)', 3, '5fdba9311c4df2380ed64a284e0c5b62', '+256-712 077229', 'd.kamugasha@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(31, 'Muyonga', 'UNCST', 'Prof John Muyonga (PhD)', 'Muyonga', 24, '4d76485578b26863108772a0ec1b792c', '+256772673153', 'hmuyonga@yahoo.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'Master\'s Degree', '1993-10-06', 'No', '', 'notknown', ''),
(32, 'Ejalu', 'Uganda', 'Ms Patricia Ejalu ', 'Bageine', 3, 'a5e6103bfd72fd3496ccbc6c4933c5bd', '0752978787', 'patricia.ejalu@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'PHD', '1998-05-03', 'No', '', 'notknown', ''),
(33, 'mktest', 'Kampala-UNCST', 'Colins', 'Mwesigwa ', 3, '79b2af95daac1a4ff85b4f813af898a6', '+256752807890', "$emailBcc", '2021-05-05 06:48:35', 1, 'reviewer', '', '9ea0810c7e97845d0e32936133c9da78', 'Male', 'Master\'s Degree', '1983-09-15', 'No', '5,6,1,3,2,', 'yes', ''),
(34, 'pbageine@unbs.go.ug', 'Uganda National Bureau of Standards', 'Patricia', 'Ejalu', 3, '26a1e025ef15dcd69f5b61de2ad09f60', '+256417333250/5', 'pbageine@unbs.go.ug', '2018-08-01 08:53:15', 1, 'user', '', '8191b29a50056b9cb10b8ae1496ce5c7', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(35, 'mmawanda2@i3c.co.ug', 'MR SOFT', 'Moses', 'Mawanda', 9, '83731fe8d862422cd071bad441a5c797', '0782086452', 'mmawanda2@i3c.co.ug', '2021-05-05 06:42:03', 1, 'reviewer', '', '', 'Male', 'Bachelor\'s Degree', '1997-07-08', 'No', '6,1,3,2,', 'yes', ''),
(36, 'pbageine', 'Uganda National Bureau of Standards', 'Patricia', 'Ejalu', 3, '26a1e025ef15dcd69f5b61de2ad09f60', '0752978787', 'pbageine@unbs.go.ug', '2018-09-03 07:34:54', 1, 'user', '', '8191b29a50056b9cb10b8ae1496ce5c7', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(37, 'Oulai Dan', 'PASRES', 'DAN', 'Oulai', 40, '1922da8906c25d9fecd9f0b127c54623', '00225 23472828', 'oulai.dan@gmail.com', '2018-09-05 16:10:00', 1, 'user', '', '980b6b94ea1c8098a43db1fa17968a0a', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(38, 'Linda', 'Kampala-UNCST', 'Linda ', 'Amanda', 3, 'ae3c882e96c1560939966850debfaa86', '0414705500', 'l.amanya@uncst.go.ug', '2019-08-28 13:52:18', 1, 'admin', '', '', 'Male', 'Master\'s Degree', '1983-04-11', 'No', '', 'notknown', ''),
(39, 'g.sempiri@uncst.go.ug', '', 'Geoffrey Sempiri', '', 0, '8cc96d32d319cf8be629af872e853fc0', '0414705500', 'g.sempiri@uncst.go.ug', '2019-08-28 13:56:03', 1, 'admin', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(40, 'Lawnsome', 'Uganda Martyrs University, Ngetta Campus Lira', 'Rev. Lawnsome', 'Etum Akezi', 3, '0e8dceb5dccb1b6a1a8fbd9e4fdccdee', '+256776344408', 'ccclira.ug@gmail.com', '2018-09-22 12:53:44', 1, 'user', '', 'd055380366f7fd7d77cefe262608bc09', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(41, 'kalungievan@gmail.com', 'Plant It Right Consult Plus', 'Kalungi', 'Evan', 3, 'c9bb81d8765f59f2444684fa1593c82f', '+256772545808', 'kalungievan@gmail.com', '2018-09-25 13:57:57', 1, 'user', '', '1f4aa5e1b93cd19e9daf3d212a21a83b', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(42, 'ddamulira', 'National Crops Resources Research Institute ', 'Gabriel', 'Ddamulira', 3, '6a0fb1beddb63e4fa41b43b028787b02', '+256 774229749', 'ddamuliragab@yahoo.co.uk', '2018-10-25 05:32:30', 1, 'user', 'nstip_DSC_0242 copy copy.jpg', '', 'Male', 'PHD', '1978-07-16', 'No', '', 'notknown', ''),
(43, 'le bÃ©ni', 'UNIVERSITE FELIX HOUPHOUET BOIGNY', 'DOMINIQUE', 'SAGOU', 40, 'f04027b5758a1219e18093ad73c725b5', '+22547969858', 'dominiquesagou89@gmail.com', '2018-10-01 22:10:14', 1, 'user', '', '531d364213b70378196a327667abede9', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(44, 'KOUASSIM', 'UniversitÃ© Felix HouphouÃ«t-Boigny', 'KAN MODESTE', 'KOUASSI', 40, '5ddbd866bdadb723ae72c8e404606b2d', '0022507923492', 'kanmodestekouassi@gmail.com', '2018-10-02 12:03:52', 1, 'user', '', '8206946eb14bd56f05efbda5496ea815', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(45, 'Edwige', 'West African Virus Epidemiology (WAVE)', 'YÃ©o', 'FoungniguÃ© Edwige', 40, '6b4688c80edaaa247b0cc1ee0a7e0da0', '0022547875130', 'yeo.edwige@yahoo.fr', '2018-10-25 11:40:24', 1, 'user', 'nstip_01.jpg', 'f15444e5507691733459ccc3db34d8b0', 'Female', 'Master\'s Degree', '1988-08-18', 'No', '', 'notknown', ''),
(46, 'walakjk', 'National Fisheries Resources Research Institute_NARO', 'John', 'Walakira', 3, 'f02c9822d9e4ac1d5186af874850b144', '+256777673696', 'johnwalakira2003@gmail.com', '2018-10-08 13:42:54', 1, 'user', '', 'cabb494d92f6b2e6d6754d21e1614458', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(47, 'pmukwaya', 'Makerere University', 'Paul', 'Mukwaya', 3, '2dc398408a3742f6ca2090dfe0748868', '+256755653419', 'pmukwaya@gmail.com', '2018-10-24 09:32:00', 0, 'user', '', '13ed95a2f28264a61967d1b0368bab1d', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(48, 'paulmukwaya', 'Makerere University', 'Paul', 'Mukwaya', 3, 'fec027bf138c03156fbe3fd3d6fdb46d', '+256755653419', 'pmukwaya@gmail.com', '2018-10-09 08:05:46', 0, 'user', '', '13ed95a2f28264a61967d1b0368bab1d', '', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(49, 'dnamson', 'FEDINCI (federation des inventeurs de cote d\'ivoire)', 'DIOMANDE', 'NAMORY', 40, 'f26f9f7a483f1afb8ee06b1f36b780ad', '(00225)48087261', 'dnamson10@hotmail.fr', '2018-10-09 10:08:07', 1, 'user', '', 'b8753265123aaf00eac7385b76d13dd9', 'Male', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(50, 'moseschemurot@gmail.com', 'Makerere University, Department of Zoology, Entomology and Fisheries Sciences', 'Moses', 'Chemurot', 3, 'db4e41d6bb9f8c42f5e3663277a68dff', '+256782285819', 'moseschemurot@gmail.com', '2018-10-10 04:35:03', 1, 'user', '', '22bcbb179178a79f04c21ecc2b12c237', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(51, 'eburegyeya', 'Makerere University School of Public Health', 'Esther', 'Buregyeya', 3, 'a0eeb3fc8ac6418bda45f22d8af9f64b', '+256752420555', 'eburegyeya@musph.ac.ug', '2018-10-11 17:52:39', 1, 'user', '', '346d155de861f4d4e4a366a1458d84f6', 'Female', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(52, 'luwemba', 'MAKERERE UNIVERSITY', 'LUWEMBA ', 'EMMANUEL', 3, 'e6b942cdd31d729232f40773fb13cae4', '+256773964301', 'emmanueluwemba@gmail.com', '2018-10-12 07:43:00', 1, 'user', '', '16f6de08bfe1fe8b24c561e8939cd957', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(53, 'ngazoa_solange@yahoo.fr', 'Institut Pasteur Cote d\'Ivoire', 'Elise Solange', 'Ngazoa Kakou', 40, '350cae9f3a2d25256a185d46c6b9ad79', '0022508240453', 'ngazoa_solange@yahoo.fr', '2018-10-15 09:29:53', 1, 'user', '', '2d255b40c95329cb3b88a749f1c97006', 'Female', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(54, 'daouda', 'UniversitÃ© Felix Houphouet-Boigny', 'KONE', 'Daouda', 40, '5529cf16dc56ea89557f4149f0ee6f23', '+22502387714', 'daoudakone2013@gmail.com', '2018-10-16 14:11:35', 0, 'user', '', '69b28a2171a3796677f46a43c6bbcb32', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(55, 'Kone', 'UniversitÃ© Felix Houphouet-Boigny', 'KONE', 'Daouda', 40, '63311af76ed94c64f954df7c1aee6d08', '+225 08 45 17 26', 'daoudakone2013@gmail.com', '2018-10-16 14:11:35', 0, 'user', '', '69b28a2171a3796677f46a43c6bbcb32', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(56, 'daoudakone', 'UniversitÃ© Felix Houphouet-Boigny', 'KONE', 'Daouda', 40, 'f80a1cf021a02d79d7275b78c5f24a10', '+22508451726', 'daoudakone2013@gmail.com', '2018-10-16 15:10:55', 1, 'user', '', '6138c82e39806c4d63b60375db128886', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(57, 'konemaimouna93@gmail.com', 'WAVE PROGRAMM- UNIVERSITE FELIX HOUPHOUET-BOIGNY', 'MAIMOUNA ', 'KONE', 40, '007dc081dc4798c351aa3ffe23749367', '+ 22509777460', 'konemaimouna93@gmail.com', '2018-10-16 16:03:53', 1, 'user', '', '936db91633f2918804611622ebcc11dd', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(58, 'Alain2dan', 'PASRES', 'Alain', 'Dan', 40, '3a686456ecf62d33d6b70e2d0706b840', '22508136106', 'oulai.dan@gmail.com', '2018-10-16 16:36:30', 1, 'user', '', '980b6b94ea1c8098a43db1fa17968a0a', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(59, 'mayambalex', 'Busitema University', 'Alex', 'Mayamba', 3, '13a033f46885e84df7994327a61dc558', '+256704881502', 'alexmayamba@gmail.com', '2018-10-17 06:34:24', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(60, 'haskader', 'University of FÃ©lix Houphouet Boigny', 'HASSANE', 'DAO', 40, '53ec317e9de91e62ca7f663243daeeaa', '+22507486385', 'daohassane1@gmail.com', '2018-10-17 21:27:56', 1, 'user', '', 'b259e926adc5ba912fc18a2cad11d5a6', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(61, 'akiggundu', 'National Coffee Research Institute', 'Andrew', 'Kiggundu', 109, 'a7ae32f0abecabea7abb323e23a97a54', '+256772516652', 'akiggundu@gmail.com', '2018-10-18 09:43:14', 1, 'user', '', '54a073f37acd7ff121e4ac0e9198d829', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(62, 'nguessanantoine1', 'UniversitÃ© Peleforo Gon Coulibaly, Korhogo', 'N\'GUESSAN', 'KouamÃ© Antoine', 40, 'e9f2f87f41dfbcc345f4467176b37f3c', '+225 07426965 / 52148204', 'nguessanantoine1@yahoo.fr', '2018-10-18 17:04:03', 1, 'user', '', 'd95a110e2891f5203f409958adac0182', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(63, 'konan wilfried kouame fabrice', 'universite felix houphouet boigny', 'konan', 'wilfried kouame fabrice', 40, '448a7ed08551ac72946327f9dfba0d95', '04129320', 'fabricekonan010@gmail.com', '2018-10-19 13:47:20', 1, 'user', '', 'b6da73bdf363834892662fc2cb025c48', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(64, 'bhonykof', 'UniversitÃ© Jean Lorougnon GuÃ©dÃ© ', 'N\'dodo Boni Clovis ', 'KOFFI', 40, '292b0f32525d3d98585b33eb871ab60b', '+22548635428', 'bhonykof@yahoo.fr', '2018-10-22 14:09:40', 1, 'user', '', '294babc8e6da16b724a0237e0c9d3975', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(65, 'koutouaseka', 'University Nangui Abrogoua', 'SEKA', 'koutes', 40, '0c1a0e72a711173976fae3f33b0d5ec8', '09971011', 'koutouaseka@yahoo.fr', '2018-10-23 07:13:09', 1, 'user', '', 'd88874d8d95bb1056c864bafb5aab7af', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(66, 'gonaga', 'National Agricultural Research Organization', 'Geoffrey', 'Onaga', 3, '73c64ec7a2f835e3a59fd76ba33a4cae', '+256 782 644928', 'geoffyonaga@gmail.com', '2018-10-24 07:18:34', 1, 'user', '', 'e6f71544e403b256fd2ad8d73e50776f', 'Male', 'Post-Doctoral', '0000-00-00', 'No', '', 'notknown', ''),
(67, 'mukwayap', '', 'Paul Mukwaya.', '', 0, '2dc398408a3742f6ca2090dfe0748868', '0755653419', 'pmukwaya@gmail.com', '2018-10-24 09:39:35', 1, 'user', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(68, 'cbyaruhanga27', 'National Agricultural Research Organisation', 'Charles', 'Byaruhanga', 3, '4cb9e9b2018a8fdc1befb26d3357f7a2', '+256 782679729', 'cbyaruhanga27@yahoo.com', '2018-10-25 01:08:09', 1, 'user', '', '4832aa57b9aa21cf73a05def9d271e2c', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(69, 'adrikoj', 'National Agricultural Research Organisation, National Agricultural Research Laboratories, P.O. Box 7065, Kampala', 'John', 'Adriko', 3, '2b20a8b544501b54fca49ccbd9e3ea15', '+256772386870', 'adrikoj@yahoo.com', '2018-11-10 02:39:01', 1, 'user', 'nstip_20180929_141001.jpg', 'beaa2154889f976bd5410a5b0c775c9a', 'Male', 'PHD', '1977-05-05', 'No', '', 'notknown', ''),
(70, 'talicai', 'National Agricultural Research Organisation', 'Titus', 'Alicai', 3, '75ecb53ebb347b676cc28666b621c690', '256772970585', 'talicai@hotmail.com', '2018-10-25 07:35:52', 1, 'user', '', '260b33040c3353814a92bc674eb8ba8f', 'Male', 'PHD', '1970-01-09', 'No', '', 'notknown', ''),
(71, 'moses.otuba', 'National Agricultural Research Organisation', 'Moses', 'Otuba', 3, '29d176595aca35554ee987d054135040', '256771661492', 'moses.otuba@gmail.com', '2018-10-25 08:52:07', 1, 'user', '', '680d022c626fc5447f7f6e047e0f8652', '', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(72, 'Blessed Jacinta', 'National Crops Resources Research Instsitite(NaCRRI)', 'Jacinta', 'Akol', 3, 'cbf3ee7430be7c9341778c4cd3607cbb', '+256 782 881 989', 'akoakol@yahoo.com', '2018-10-25 09:24:27', 1, 'user', '', '001c3d859661a5baf15c7b814164a961', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(73, 'isunju', 'Makerere University School of Public Health', 'John Bosco', 'Isunju', 3, '745a8678623660858aa6972d216b93d9', '+256772346304', 'isunju@musph.ac.ug', '2018-10-25 12:58:39', 1, 'user', '', 'c0a081bc46f99f44319cc151d5d3071a', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(74, 'j.serumaga', 'National Agricultural Research Organisation', 'Julius Pyton', 'Sserumaga', 3, 'af9798932c61da8c40a8950c6e5d54f1', '+256774873595', 'j.serumaga@gmail.com', '2018-10-25 13:16:08', 0, 'user', '', '5a095b0aa5c0210e584fde8713451f00', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(75, 'dognimeton ', 'UNIVERSITÃ‰ JEAN LOROUGNON GUEDE', 'SORO', 'DOGNIMETON', 40, 'a07056f64567b710bbae38b38058b301', '+225 47941598', 'dognysoro@gmail.com', '2018-10-25 14:25:28', 1, 'user', '', 'd09cdadcbd8f001aecd5cf7512acda0d', 'Male', 'Post-Doctoral', '0000-00-00', 'No', '', 'notknown', ''),
(76, 'Val1980', 'National Agricultural Research Organization, Nabuin Zonal Agricultural Research and Development Institute', 'Vallence', 'Nsabiyera', 3, '8dbd8b22c022a355b7fb8716571a3c75', '+256782230258', 'vallenceacademic@gmail.com', '2018-10-25 16:46:58', 1, 'user', '', '2f4bcec7f26d5a55317bb98474687d02', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(77, 'degaule2k@gmail.com', 'UniversitÃ© de BouakÃ©', 'KOUAME DEGAULE', 'KONAN', 40, 'd2a776f52c37774a138b789b0f24df63', '(+225)08768373', 'degaule2k@gmail.com', '2018-10-26 12:24:42', 1, 'user', '', '7123fa28ef506c9133ebea25e02ea17c', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(78, 'Arthey', 'National Agricultural Research Organisation', 'ARTHUR', 'WASUKIRA', 3, 'f63a4dfb5e907490488d6bc5d47251c5', '782427527', 'awasukira@gmail.com', '2018-10-31 09:44:51', 1, 'user', '', '42143c5928775c8af0d9125c0441aa2c', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(79, 'fabricekonan010@gmail.com', 'universite felix houphouet boigny', 'konan', 'wilfried kouame fabrice', 40, 'd862c651d1571ab993d96d15cd59c70f', '04129320', 'fabricekonan010@gmail.com', '2018-11-13 13:07:17', 1, 'user', '', '69c86694af878b7edc9c3cc5d28475b9', 'Male', 'Master\'s Degree', '1990-12-15', 'No', '', 'notknown', ''),
(80, 'dan', '', 'Oula Dan', '', 0, '980b6b94ea1c8098a43db1fa17968a0a', '23 47 28 29', 'oulai.dan@gmail.com', '2019-08-28 13:54:39', 1, 'admin', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(81, 'Jimmy', '', 'DR JIMMY LAMO', '', 0, '77462937ee51298e296317d3766d2828', '0772342757', 'jlamoayo@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(82, 'denis', 'MSmsmsms', 'ASSOC PROF DENIS MPAIRWE', 'snssnsnsns', 29, 'c3875d07f44c422f3b3bc019c23e16ae', '0414705500', 'dmpairwe@caes.mak.ac.ug', '2019-10-14 09:23:26', 1, 'reviewer', '', '', 'Male', 'PHD', '1999-04-04', 'No', '5,6,1,3,2,', 'notknown', ''),
(83, 'mukasa', '', 'DR SSETTUMBA MUKASA', '', 0, '1a4c006df9d335d21b7e8d20993f042d', '0782670041', 'sbmukasa@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(84, 'duncan', '', 'DR DUNCAN ONGENG  ', '', 0, 'f4d677934c35431de0c814a1bdc9993c', '0782673491 /0750483583 ', 'duncanongeng@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', '', '0000-00-00', 'No', '', 'notknown', ''),
(85, 'karungi', 'MAK', 'ASSOC PROF JENINAH KARUNGI', 'Karungi', 3, '7aaf3d0b420ce64bc6e22687feaa4b22', '0414705500', 'jkarungi@caes.mak.ac.ug', '2019-10-14 09:23:46', 1, 'reviewer', '', '', 'Male', 'Bachelor\'s Degree', '1998-06-06', 'No', '5,1,', 'notknown', ''),
(86, 'William', 'UNCST', 'PROF WILLIAM KYAMUHANGIRE', 'KYAMUHANGIRE', 38, '38549f173db022275b9e485cb7993534', '07720519422', 'wkyamuhangire@yahoo.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'PHD', '1995-06-05', 'No', '', 'notknown', ''),
(87, 'godfrey', 'MAK', 'DR GODFREY ASEA', 'Grace', 36, '7a20110ac6d94e8e68c50de6d85bb04b', '0414705500', 'grasea9@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Female', 'PHD', '1998-04-07', 'No', '', 'notknown', ''),
(88, 'john', 'Makerere University', 'John', 'Tabuti', 3, 'f5ff1350e470534c7dde5d1a0f69560f', '+256772960880', 'jtabuti@gmail.com', '2019-10-14 13:06:06', 1, 'reviewer', '', '', 'Male', 'PHD', '1965-09-22', 'No', '5,3,', 'notknown', ''),
(89, 'DR ISA KABENGE', 'Makerere University', 'DR ISA ', 'KABENGE', 3, '2349c1e766b7f0981194da57d6c9300e', '0772377172', 'isakabenge@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(90, 'camara', 'Centre National de Recherche Agronomique (CNRA)', 'PROF CAMARA MAMERI', 'Mameri', 40, 'dc0ec7177498654fb9cc1d89e67ef672', '02 02 10 96/05 25 69 39', 'Camara_mameri@yahoo.fr', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'PHD', '1952-01-01', 'No', '', 'notknown', ''),
(91, 'casirmir', 'MAK', 'PROF BROU YAO CASIMIR ', 'Casimir', 26, 'dbd2ab5b5dd1fa054867e785cf6ed01f', '07 58 79 05/ 02 03 35 86', 'ycasimir.brou@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', 'PHD', '1997-07-07', 'No', '', 'notknown', ''),
(92, 'allassane', 'University of Nangui Abrogoua', 'PROF OUATTARA ALASSANE ', 'Allassane', 40, '9471bf442c2cd54c8491340a1db4fed5', '05 08 71 84', 'allasane_ouattara@hotmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'PHD', '1970-01-29', 'No', '', 'notknown', ''),
(93, 'tie', 'MAK', 'PROF TIE BI TRA', 'TRA', 39, '3dee5f5794b78fa97fb6ead8f9f96bda', '01 17 16 56', 'tratiebi07@gmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'PHD', '1998-06-04', 'No', '', 'notknown', ''),
(94, 'sangare', 'UNCST', 'PROF SANGARE  ABDOURAHAMANE ', 'ABDOURAHAMANE', 35, '20d42e44d0abe70f3e15a10f0d45d2b2', '0414705500', 'abou.sangare@yahoo.fr', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', 'Master\'s Degree', '1998-08-07', 'No', '', 'notknown', ''),
(95, 'soro', 'UNCST', 'PROF SORO NAGNIN ', 'NAGNIN ', 32, 'aae740da6e8aeb3072e2a41be473a4b1', '07 88 27 67/ 01 06 48 17 ', 'soro_nagnin@yahoo.fr', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', 'Master\'s Degree', '1994-06-04', 'No', '', 'notknown', ''),
(96, 'koffi', 'UNCST', 'PROF KOFFI KOUAME KEVIN ', 'KEVIN', 31, '4807251109ab398c829507617a526234', '0414705500', 'koffikevin@yahoo.fr', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', 'PHD', '1995-05-05', 'No', '', 'notknown', ''),
(97, 'ayolie', 'MAK', 'PROF AYOLIE KOUTOUA ', 'Consty', 30, 'c81a5c63927eb0e7e33da4d0ccaf46fb', '47 94 77 69', 'consty6@hotmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '', 'Male', 'Post-Doctoral', '1986-05-16', 'No', '', 'notknown', ''),
(98, 'konan', 'UNCST', 'PROF KONAN WAIDHET ARTHUR BRICE ', 'ARTHUR BRICE ', 33, '13958c6d53b6aab2184d26eca5a2109d', '47 93 87 28', 'konanwab@yahoo.fr', '2019-05-24 11:48:32', 1, 'reviewer', '', '', '', 'PHD', '1996-06-08', 'No', '', 'notknown', ''),
(99, 'Abou Sangare', 'Centre National de Recherche Agronomique (CNRA) CÃ´te d\'Ivoire', 'Abdourahamane', 'SangarÃ©', 40, '36febca0e9267477d9b581da1a11b00f', '7720 2756', 'abou.sangare@yahoo.fr', '2018-11-23 13:58:27', 1, 'user', '', '20d42e44d0abe70f3e15a10f0d45d2b2', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(100, 'Asea.1', 'National Agricultural Research Organization', 'Godfrey', 'Asea', 3, 'c9f3230c0ea97735663d7f56a3c49828', '+256 782031285', 'grasea9@gmail.com', '2018-11-22 15:10:56', 1, 'user', '', '7a20110ac6d94e8e68c50de6d85bb04b', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(101, 'casimir', 'National Polytechnic F. HouphouÃ«t-Boigny Institute', 'Yao Casimir', 'BROU', 40, 'dbd2ab5b5dd1fa054867e785cf6ed01f', '((225) 07  5 8 79 05', 'ycasimir.brou@gmail.com', '2018-12-04 06:06:40', 1, 'user', '', 'dbd2ab5b5dd1fa054867e785cf6ed01f', 'Male', 'PHD', '1968-01-01', 'No', '', 'notknown', ''),
(102, 'Brou', 'Institut National Polytechnique F. HouphouÃ«t-Boigny (INP-HB)', 'Yao Casimir', 'BROU', 40, 'c27da820117dc9a8139c96789740718f', '(225) 02 31 1912', 'ycasimir.brou@gmail.com', '2018-12-03 15:35:44', 1, 'user', '', 'dbd2ab5b5dd1fa054867e785cf6ed01f', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(103, 'wmasiga@hotmail.com', 'Makerere University', 'Dr. Clet', 'Masiga', 3, '627e388f37735db021a608619e0e5cca', '0414705500', 'wmasiga@hotmail.com', '2019-05-24 11:48:32', 1, 'reviewer', '', '627e388f37735db021a608619e0e5cca', '', 'PHD', '1981-07-18', 'No', '', 'notknown', ''),
(104, 'pnampala@yahoo.co.uk', 'Kampala-UNCST', 'Dr. Paul', 'Nampala', 3, '5760ea9f4a14b89367bac9e83491a0b5', '0414705500', 'pnampala@yahoo.co.uk', '2019-05-24 11:48:32', 1, 'reviewer', '', '5760ea9f4a14b89367bac9e83491a0b5', 'Male', 'PHD', '1970-12-19', 'No', '', 'notknown', ''),
(105, 'BerniceRacheal', 'Makerere University', 'Bernice', 'Nazziwa', 3, '5f6491feda672208517d09d03e4eaf90', '0757899595', 'berracheal23@gmail.com', '2019-01-09 08:24:59', 0, 'user', '', '7d451574744e1086695a612d4a6c1714', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(106, 'cmwesigwa', 'UNCST-Kampala', 'Collins', 'Mwesigwa', 3, '7df5222fb59b99c7c598bee2ef00b85e', '0414705500', 'mwesigwa.collins@gmail.com', '2021-02-20 09:52:12', 1, 'user', '', '8cba3da147282ed7aadc39529827b884', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(107, 'Noreen-mina', 'Mbarara university of science and technology', 'Noreen', 'Atwijukire', 3, '002cce23f5d1c3014b3748d00c11a22f', '0788792761', 'noreenminatwiju@gmail.com', '2019-01-24 19:13:39', 1, 'user', '', '61a2871ba40934c3c1132a81f090b070', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(108, 'Raymond', 'Ministry of Health', 'Raymond', 'Asiimwe', 3, 'cc9a5c91adb45705f5cc03c076bdfb94', '0781762696', 'raymond162@gmail.com', '2019-01-29 10:54:14', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(109, 'kakande angelo', 'Makerere University', 'Angelo', 'KAKANDE', 3, '74f4c4d4c5a9472a14e90c56a41303e0', '+256772590361', 'kakandeangelo@gmail.com', '2019-02-16 20:09:48', 1, 'user', '', '3a82f5d4df41e47915ba6aa29af1ee3a', 'Male', 'Post-Doctoral', '0000-00-00', 'No', '', 'notknown', ''),
(110, 'XODDO', 'Makerere University', 'XODDO', 'PO', 3, '007288bb027cf9127ee762f4dcd06a17', '+256771311130', 'xoddopaul@gmail.com', '2019-02-28 05:43:19', 1, 'user', '', '6992e4113ed0d1c6c669edbe7ae62491', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(111, 'chale judith', 'Gulu University', 'Judith', 'Chale', 3, 'd982a9f07f80a496a772563f3858b60c', '+256784487405', 'asiljulian@gmail.com', '2019-04-02 05:27:48', 1, 'user', '', 'c3845e5b611db61a88ff4e3766f748a1', 'Female', 'Bachelor\'s Degree', '1990-04-10', 'No', '', 'notknown', ''),
(113, 'SSENKEERA', 'College of  Veterinary Medicine Animal Resources and Biosecurity', 'Ben', 'Ssenkeera', 3, '8402ada58a3681280d390463c0d3234c', '+256779221497', 'bssenkeera@gmail.com', '2019-06-04 21:46:06', 1, 'user', '', '238e94493c4dce7a5b78322928a11a99', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(114, 'Wence', 'WINGERsoft Technologies Ltd', 'Wence', 'Benda', 3, '68790a40169cbc73d64d90c520b09128', '256785485346', 'twenceb@wingersoft.co.ug', '2019-06-06 07:35:59', 1, 'user', '', '0d9294703b487be5aaa1aa3bdc0e1adb', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(115, 'mbbaraka', 'Muni University', 'Mark Bright', 'Baraka', 3, '0e6a53ed6bd85785c67e10bd543c097c', '773034311', 'markbrightbaraka@gmail.com', '2019-06-06 08:31:42', 1, 'user', '', 'a5a9349525271d45e2917a0c301ff47e', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(116, 'Kstarnley', 'Uganda Christian University', 'Kaggwa', 'Starnley', 3, '44619e66ac3db6cfec7674121c1f352a', '+256778081724', 'kstarnley288@yahoo.com', '2019-06-07 18:10:14', 1, 'user', '', '29889d978169bbf18814dc85ac068b17', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(117, 'jazlynw', 'University of Alberta', 'Jazlyn', 'Wiebe', 9, 'f4393cca49c336a563182a9ae24d4477', '7809961888', 'jazzyjaz.wiebe@gmail.com', '2019-06-10 07:39:50', 1, 'user', '', 'e6f049cc08339e4c40e26f8a042dc0de', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(118, 'grantstest3', 'UNCST-Kampala', 'Mwesigwa', 'James', 3, '0819f1fd0330a95b2488252d68d0f67e', '0752807890', 'cmwesigwa@ifrontiers.net', '2019-06-17 07:34:29', 1, 'user', '', 'b022fb2520a804cae6ac98979693a259', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(119, 'okello256', 'Maarifasasa Limited', 'Robert', 'Okello', 3, '0b511ba382daddead3f9e2efb92f0bd8', '783146325', 'okello@maarifasasa.com', '2019-06-20 08:46:11', 1, 'user', '', '54f8a801281524d0cb8e2cd3c5eb28f3', '', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(120, 'Simon Afrika', 'Makerere University-Johns Hopkins University Research Collaboration ', 'Simon Afrika', 'Akasiima', 3, '3844752d36bb3c08a57b0d8b4ebc2356', '+256772688530', 'akasiima@yahoo.com', '2019-06-21 22:08:35', 1, 'user', '', '39d82d8d4789e0ba98c86d7edb6b9893', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(121, 'Fwadidi', 'Makerere University School of Law', 'Frank', 'Wadidi', 3, '975aa27b7c530eec41d94062c93d929e', '+256775425175', 'frank.wadidi.2016@gmail.com', '2019-06-24 17:02:22', 1, 'user', '', '76aff5555a421501e7509ad5732e9f57', '', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(122, 'oryang', 'Freelance Programmer', 'Richard', 'Oryang', 3, 'a9f1ef493511f2fdecbe95fdb4b00fa8', '0789267295', 'oryangrich@gmail.com', '2019-06-25 06:49:33', 1, 'user', '', '01d67ef5f8cf7e3935f13a277f892932', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(123, 'mmbatudde', 'Faculty of Environment and Agricultural Sciences, Ndejje University', 'Maria', 'Mbatudde', 0, '4d24b211d76dda6ef91a2c0a1947c04c', '+256 772316260', 'mmbatudde@ndejjeuniversity.ac.ug', '2019-06-28 02:44:03', 1, 'user', '', '145ff450e590f69a37dcef7862f902c4', 'Female', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(124, 'mosemb', 'Ultimate Data', 'Moses', 'Mbabaali', 0, '6f6a0281d50d6edb5bea27b20a714859', '+256785036400', 'mosejava@gmail.com', '2019-07-01 14:04:34', 1, 'user', '', '9ea18dbaf97c48f9c6197a453ef0fbb1', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(125, 'Calvine', 'Fenix International', 'Calvine', 'Malinga', 3, '3d84af909c0b56796a6b7b16e3603e2d', '+256776828488', 'mc.calvine88@gmail.com', '2019-07-03 17:54:41', 1, 'user', '', '744a5278f92367399a6a2f48ba8d94dd', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(126, 'Kawalya', 'Makerere university of medical sciences', 'Steven', 'Kawalya', 3, '9cc49be16de444ec415f05a6a77940a8', '+256 750037855', 'kawalyamlt@gmail.com', '2019-07-09 09:00:36', 1, 'user', '', '48645c51f1ed2ad7764691ca9b7cd04a', 'Male', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(127, 'Eilu', 'Uganda Christian University', 'Emmanuel ', 'Eilu', 3, 'c4690696d74a2efe360752b8d3411e31', '+256772687232', 'eiluemma@yahoo.co.uk', '2019-07-10 09:23:26', 1, 'user', '', '147eb6b77e2f0122520e0f23ac679ed6', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(128, 'Bwenje Paul ', 'Uganda Institute of Allied Health and Management Sciences Mulago ', 'Paul ', 'Bwenje ', 3, '1dcd341c4ffe9b985e4415e15f13f075', '0781797803', 'bwenjepaul@gmail.com', '2019-07-11 20:35:59', 1, 'user', '', '9fd3721f0d53acfb121d2236af3ad5ea', 'Male', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(129, 'joventapollo', 'KABALE UNIVERSITY', 'JOVENT', 'WABWIRE', 3, 'c8ca1098898ca7f4fec4234d7a4bdd2f', '+256751224011', '17adme0182f@kab.ac.ug', '2019-07-13 09:03:42', 1, 'user', '', '74df037726ef57db83df8dc93f7195b7', 'Male', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(130, 'farouk', 'THETA Uganda', 'Minawa', 'Faluku', 3, '85478d6d6402de1e1f93c1a02c87191e', '+256772413623', 'minawahfaroukh@gmail.com', '2019-07-15 10:56:17', 1, 'user', '', '6185028b10614a9eac9dc6d46cdaf711', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(131, 'Etwalu', 'Makerere University', 'Etwalu', 'Emmanuel Brian ', 0, 'dfa754639ec4b14839ceaa48500d29fc', '+256704925127', 'etwaluemmanuelbrian@gmail.com', '2019-07-19 17:45:15', 1, 'user', '', 'df060f61ae5ccde181ba77d62bb5fa23', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(132, 'Fortunate Abaho', 'Kiruhura Women in Development', 'Fortunate', 'Abaho', 3, '8be4e235bca4f4e5288de47d67bc51ac', '0788008499', 'abafort@gmail.com', '2019-07-20 15:37:55', 1, 'user', '', '117877cd43d91dd4e7f35079966bfb43', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(133, 'odongopancras', 'Lira University', 'Pancras', 'Odongo', 3, 'ea7a4d7bf526b69aaddf07087fd081ae', '0772442776', 'odongopancras@gmail.com', '2019-07-22 13:19:52', 1, 'user', '', '493c146e65f093f9a4ce823d51640322', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(134, 'Dora ', 'Makerere University', 'Dora ', 'Bampangana', 3, 'c59c5fdcade8a34dcf31c51512fea441', '+25677621910', 'bampa2008@gmail.com', '2019-07-23 07:18:29', 1, 'user', '', 'd1793c6c7c6d334891808aae7d6f9496', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(135, 'christo', 'DoxaLight Incorporation', 'Innocent', 'Drajo', 0, '47be19127c66c18c9208258529c74536', '0783335335', 'xristoinno@gmail.com', '2019-07-26 21:14:39', 1, 'user', '', 'a800473909ca27d76373de206034eb80', 'Male', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(136, 'xristo', 'DoxaLight Incorporation', 'Innocent', 'Drajo', 3, '47be19127c66c18c9208258529c74536', '0783335335', 'xristoinno@gmail.com', '2019-07-26 21:14:39', 1, 'user', '', 'a800473909ca27d76373de206034eb80', 'Male', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(137, 'jerryictho', 'Doctors with Africa CUAMM', 'Jerry', 'Ictho', 3, 'abf5bc7d389cd6b69dce4a11e0c26bbe', '+256754612985', 'ictho@live.com', '2019-07-31 12:50:11', 1, 'user', '', '2c17b058b6c81e49fffb127eeb148879', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(138, 'walshbaw', 'Bawellz center for Excellence', 'Frank Walsh', 'Bawera', 3, '091427314858ba3737df110efa8b7567', '+256-788-899-573', 'walshbaw@gmall.com', '2019-07-31 18:16:34', 0, 'user', '', 'ca518ba997a92d10af5fee07328294d4', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(139, 'ftumuhaise', 'Makerere University', 'Fortunate', 'Tumuhaise', 0, '42c90d87649d808b36236951f40293a5', '+256752553067', 'tfortu@gmail.com', '2019-08-02 21:17:14', 1, 'user', '', '76d02fd6f2f895561b19edad9744e7ad', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(140, 'hedmono@gmail.com', 'Mbarara University of Science and Technology', 'Hedmon', 'Okella', 3, 'c011c791508f56479866229c09227723', '+256773401474', 'hedmono@gmail.com', '2019-08-04 11:00:00', 1, 'user', '', '22fd59d1ec91e2fe42315c5fe5b19502', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(141, 'ogula', 'northern uganda effort for the needy (nuen)', 'ogula', 'johnson', 3, 'f33624846ae42e5c65da8162c5f12d42', '256774127024', 'nuenonline@yahoo.com', '2019-08-05 10:37:13', 1, 'user', '', '71346fb88ac03f2e1e58d37ab527221d', 'Male', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(142, 'defacerdz', 'dsfdsfdsf', 'dddddddd', 'dddddd', 25, 'e09ed82dbd0ee6a6faef0915c2650c6c', '452848545284', 'defacerdz@gmail.com', '2019-08-10 11:48:11', 1, 'user', '', 'b47f4534c68a31bf06be2b8f71b56bb3', 'Male', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(143, 'Bawate', 'Kamuli District Local Government', 'Charles', 'Bawate', 3, '61b9a2aea8207a0f13b9e9002e473854', '0774006908', 'charlesbawate@yahoo.com', '2019-08-10 19:20:35', 1, 'user', '', '3cd7d6e37008dca9e12b6de3ab8b3f8c', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(144, 'muhumuzajb', 'Kabale University', 'John Bosco', 'Muhumuza', 3, '002fb1d4c66c14c400c445fc9ef5be50', '0772031051', 'muhumuzajb@yahoo.com', '2019-08-11 17:37:56', 1, 'user', '', '171592e1626f67498972c70b7922d9ec', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(145, 'mulamata', 'African Aquaponics  Community Fish Farmers Cooperative Society', 'Charles', 'Mulamata', 0, 'b0c3825daac5f40bb0bedd397881a79e', '0702643027', 'infomarkc5@gmail.com', '2019-08-12 18:58:44', 1, 'user', '', '26e8131b938da9d60fc235d5c679858d', '', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(146, 'Jose', 'Allied Migrant Forum SA', 'Joseph', 'Asiiwa', 3, '5dec6819345e62e66dc938a1aecaabdb', '+27 (0)183818165', 'josephasiiwa@yahoo.co.za', '2019-08-13 10:41:25', 1, 'user', '', '173b4959b3d5cfd2bda81133f6deee32', 'Male', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(147, 'Vasileva', 'JSC SSC TRINITI', 'Svetlana', 'Vasileva', 102, 'da9f2b542bdadf25391b00769dfe1d7c', '0074958415261', 'vasileva@triniti.ru', '2019-08-14 09:21:46', 1, 'user', '', 'cd8f79806ada045a42a906324f8c7979', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(148, 'Dan-williams', 'Glory Institute of Business Studies', 'Robin', 'Ouma', 3, 'e5f4fbdcfd30da72a2b0f2ea90acc63c', '+256774708855', 'mrbndanwilliams4@gmail.com', '2019-08-14 11:37:23', 1, 'user', '', '662f70cdc0101d8da1a92fa9a8f4ab9c', 'Male', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(149, 'Hoshuahenry', 'Ernest Cook Ultrasound and Research Institute', 'henry', 'Kiganda', 3, '324bf30a0fd3b772a5b47190647f6dab', '0700294551', 'hhoshua@gmail.com', '2019-08-15 14:25:12', 1, 'user', '', '5e0f4bacf31d27cd7b5db3d1e04ce1e6', '', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(150, 'justinen64', 'Makerere University', 'Justine', 'Nalunkuuma', 0, '9fe05f6c89715ba2aea5ad876d5c3b97', '+256774807272', 'justinen64@gmail.com', '2019-08-16 15:14:02', 1, 'user', '', 'ccf1b662cce17b24e17fe277a900830d', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(151, 'Latitlok', 'St. John Paul II college gulu', 'Godfrey', 'Topaco', 3, 'cf0e961e422a252d0a5b6829d66f2584', '+256782782705', 'godfreytopacoapr@gmail.com', '2019-08-19 14:04:48', 0, 'user', '', 'ea96c06b0e4646ca6913ed4838876a67', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(152, 'LUKUBYE BEN', 'Mbarara University of Science and Technology', 'LUKUBYE', 'BEN', 3, '5c49946ffae8f479227ef00a44e74f9e', '+256759668325', 'lukubyeben@gmail.com', '2019-09-28 06:00:05', 1, 'user', '', 'e2138fa2409e7e906492c909958a6be1', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(153, 'davidlugya', 'KYAMBOGO UNIVERSITY', 'DAVID', 'LUGYA', 3, '05005e6e070db37d523a7871052371cc', '0758325666', 'davidlugya97@gmail.com', '2019-08-22 09:03:16', 1, 'user', '', '989f5aa2d5da359f1b66f258f93d0b46', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(154, 'Kisawuzi', 'Electrical Controls & Switchgear Ltd', 'Joel', 'Kisawuzi', 3, '7b3f72898199b038e572539621e8250c', '+256 773465206', 'joelkisawuzi@gmail.com', '2019-08-23 08:29:12', 1, 'user', '', '1aa1b2f1658581115e3cc297820c9e19', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(155, 'Pouris', 'National Research Foundation', 'Anthipi', 'Pouris', 0, 'bf48607bb8700000538811a0bb3d7643', '0834562041', 'Anthipi@mweb.co.za', '2019-08-25 18:57:38', 1, 'user', '', 'f046ace3b94df6e911a28c2e42caf423', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(156, 'Billy ', 'KWAN INITIATIVE ', 'BILLY WILLIAM ONEN', 'ONEN', 3, '3b7cde8605234b1b819e54e9aa7b929d', '+256786448019', 'billywilliamonen@gmail.com', '2019-08-26 07:26:34', 1, 'user', '', '720ed669b3c020a269e1ca460cfc7baf', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(157, 'Buti', 'University of South Africa', 'Buti', 'Tlhoaele', 13, '7cf94f392d501f82df5fbe1b3538c3b9', '0822152210', 'buti.tlhoaele@outlook.com', '2019-08-26 19:05:58', 1, 'user', '', 'b3184d2f768401114d2b9f8380eed328', 'Male', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(158, 'wadenga george', 'IN TIME CONSULT', 'WADENGA', 'GEORGE', 3, '7e79cb6a26a67a82b5514558140f4364', '+256771456814', 'wadenga1992@yahoo.com', '2019-08-27 10:23:12', 1, 'user', '', '08f4ff0822f2a2c10cfd383dfe049cb8', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(159, 'jisiko', 'Makerere University', 'Joshua', 'Isiko', 3, '41196d056a411170eb6df6f1f428dbce', '+256782746778', 'joshuaisiko@gmail.com', '2019-08-27 14:14:22', 1, 'user', '', '903e67762be6a3cbbf3a7484cc5a34f1', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(160, 'Buregeya', 'Makerere University', 'Onesmus', 'Buregeya', 0, '89232cb5c4122a83586b698f5a14bb43', '0783147971', 'beonesmus@gmail.com', '2019-08-28 09:20:48', 1, 'user', '', '961caa183496e108093a54ba80c6c245', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(191, 'august42020@gmail.com', 'UNCST Grants Management', 'October', 'Twelveth Twenty Nineteen', 0, 'b4f79b343faf7c6fc6a52a47221fe8a5', '0752807890', 'august42020@gmail.com', '2019-10-30 06:14:08', 1, 'user', '', '', '', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(162, 'mmawanda@i3c.co.ug', 'MR SOFT CONSULTS', 'Moses', 'Mawanda', 13, 'eed4da3215440cef91548fa8743e78eb', '0701228872', 'mmawanda@i3c.co.ug', '2019-10-09 08:02:00', 1, 'user', 'nstip_20150722_100952.jpg', 'eed4da3215440cef91548fa8743e78eb', 'Male', 'Bachelor\'s Degree', '1996-08-09', 'No', '', 'notknown', ''),
(163, 'faisal2', 'uganda NCST', 'faisal2', 'kiranda', 3, 'd135ab4a9c8809726d1c609b28b4193b', '+256752808452', 'f.kiranda@uncst.go.ug', '2019-08-29 08:08:45', 1, 'user', '', '2ed939740bb69cf1feba6152c7286cf8', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(167, 'nrimsusertest@gmail.com', 'UNCST Ntinda', 'NRIMS', 'User', 3, '2ac9cb7dc02b3c0083eb70898e549b63', '0752807890', 'nrimsusertest@gmail.com', '2019-08-30 09:04:45', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(166, 'harrietnakayenga@gmail.com', 'UNCST', 'Harriet', 'Nakayenga', 3, 'dcd22200ce21f61342fbce79eaf9958e', '0789287654', 'harrietnakayenga@gmail.com', '2019-08-30 07:36:35', 1, 'user', '', '', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(168, 'Ecomamas', 'Eco Mamas Global', 'Blake', 'WIlson', 9, 'bb186f9dc245510bf3fa86e8ee1f374e', '18672222528', 'jblakewilson@gmail.com', '2019-08-31 21:03:16', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(169, 'augof2019@gmail.com', 'KAGA SACCO', 'September', 'First', 3, '2ac9cb7dc02b3c0083eb70898e549b63', '78787878888', 'augof2019@gmail.com', '2019-09-01 08:14:32', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(170, 'faisal1', 'uganda ncst', 'faisal', 'kiranda', 3, '2aa1500913310cc8a60c8719d0cfa960', '+256752808452', 'kirandafai2025@gmail.com', '2019-10-14 12:32:32', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(172, 'namikkaruth@gmail.com', 'UNCST', 'Rhona', 'Luwedde', 26, 'da92a2d493e9b784c477ceecbff6b5b7', '256701228872', 'namikkaruth@gmail.com', '2019-10-11 13:15:12', 1, 'reviewer', '', 'da92a2d493e9b784c477ceecbff6b5b7', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '5,6,1,3,2,', 'yes', ''),
(173, 'TAREMWAJOSEPH', 'engineering', 'taremwa', 'joseph', 3, '3982f3261cf508ba7c02bd7dc0b1324b', '+256788739959', 'taremwaosephinnocent@gnail.com', '2019-09-03 15:02:19', 0, 'user', '', 'daf422fbbc758011776fb0d27cee2d32', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(174, 'Kith', 'International university of East Africa', 'Thomas', 'Kiiza', 3, '9de1a6e5225796f3a6766405e017d530', '+256751788850', 'thomas.kiiza@gmail.com', '2019-09-03 23:02:44', 1, 'user', '', '', 'Male', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(175, 'buyinzalameka', 'MAKERERE UNIVERSITY', 'LAMEKA', 'BUYINZA  SEGUYA YIGA', 3, '291e9166b6b1429a9d8cb39efe5f38eb', '+256779138953', 'blameka1@yahoo.com', '2019-09-08 02:11:57', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(176, 'twesigyenduhura@gmail.com', 'KABALE UNIVERSITY', 'TWESIGYE', 'NDUHURA', 3, '06ec89327702a1dc6c6e650587c614a2', '0774881287', 'twesigyenduhura@gmail.com', '2019-10-21 19:12:04', 0, 'user', '', '9e73c2dc2ad034d4ab37a1c98694b4de', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(177, 'ogwang joel', 'No affiliation as yet - Freelance', 'Joel', 'Ogwang', 3, '2d0f8a2eb0f47974606d8f40526cc981', '0787783670', 'ogw.joel@gmail.com', '2019-09-16 12:19:10', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(178, 'BRUTWIN', 'KABALE UNIVERSITY', 'BRUCE ', 'TWINAMASIKO', 3, 'dcc9db8b00f404904b921f2c2f8dd845', '+256772382195', 'bbrutwin@gmail.com', '2019-09-17 16:22:25', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(179, 'jmbabali', 'WATER OUT OF SAFE HOLDER (WOOSH) LTD', 'John', 'Mbabali', 3, '52f1a4dbe039e79ea5132dda33118415', '+256779914253', 'jon12_cena@rocketmail.com', '2019-09-18 09:19:34', 1, 'user', 'grants_IMAG1416.jpg', '', 'Male', 'Bachelor\'s Degree', '1993-01-26', 'No', '', 'notknown', ''),
(180, 'Wampula', 'Child Pride Uganda', 'Felix', 'Wampula', 0, '827cd093dc07c2ec8cc593c09e5b0eb9', '+256782301501', 'wampulafelix@gmail.com', '2019-09-19 14:23:38', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(181, 'Kanaabi norman', 'Invention', 'Norman', 'Kanaabi', 3, '0e71cd230daf3079423216b60c83a130', '0754294323', 'normanshirquiror1234@gmail.com', '2019-09-22 08:23:14', 0, 'user', '', '30605d74cf9a6cb3f361018accd40365', '', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(182, 'jonahnsamba', 'Central University of Kerala', 'Jonathan', 'Nsamba', 3, '4c8be5d3cb7659c2ebbd455eaaded3a4', '0772551119', 'jonahnsamba@ymail.com', '2019-09-23 09:17:55', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(183, 'AmaraHub', 'Amara Hub', 'Daniel', 'Odongo', 3, '67876f492a447534bde8039941d6e295', '+256778800552', 'daniel@amarahub.org', '2019-09-24 19:26:47', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(184, 'akram256', 'Makerere University', 'Akram', 'Mukasa', 3, 'fbcf0ebda30b5e32de4525dc6dc6d170', '+256700242905', 'mukasaakram55@gmail.com', '2019-09-29 00:25:25', 0, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(185, 'Mwalye', 'Makerere University', 'Stevens', 'Mwalye', 3, '054bf6aaa15b595737f741a2d2710998', '0774968722', 'mwalyesteven@gmail.com', '2019-09-30 16:38:44', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(186, 'Andreisabirye', 'IPB property managers', 'Andrew', 'Isabirye', 3, '992c5b81fe6dcd49b8a363ed6864d14f', '0756920104', 'andreisabirye@gmail.com', '2019-10-02 01:30:28', 1, 'user', '', '', 'Male', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(187, 'luwedderhona@gmail.com', 'UNCST', 'Rhona', 'Luwedde', 3, 'd2a9e4940dbe68c65a9abb2e1044af4b', '0701229988', 'luwedderhona@gmail.com', '2019-10-04 13:09:17', 1, 'user', '', '', '', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(188, 'Asia', 'Maendeleo Foundation', 'Asia', 'Kamukama', 3, 'f2595312c865435192379a360aecf85e', '+256775987250', 'kamukama.asia@gmail.com', '2019-10-04 19:05:45', 0, 'user', '', 'fa38afcb48f301a8346417494556a9a1', '', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(189, 'cmwesigwa@ifrontiers.net', 'Kampala-UNCST', 'Mwesigwa', 'Collins', 3, 'b022fb2520a804cae6ac98979693a259', '0752807890', 'cmwesigwa@ifrontiers.net', '2019-10-10 08:09:25', 1, 'admin', '', 'b022fb2520a804cae6ac98979693a259', 'Male', 'Master\'s Degree', '1990-08-15', 'No', '', 'notknown', ''),
(190, 'kolynz2000@yahoo.com', 'UNCST Kampala', 'Jonathan', 'Lwanga', 29, 'affba84de12a8c15d975037805181111', '07890909090', 'kolynz2000@yahoo.com', '2019-10-12 07:37:54', 1, 'reviewer', '', 'affba84de12a8c15d975037805181111', 'Male', 'Master\'s Degree', '0000-00-00', '', '6,', 'yes', '');
INSERT INTO `ppr_musers` (`usrm_id`, `usrm_username`, `usrm_NameofInstitution`, `usrm_fname`, `usrm_sname`, `usrm_Nationality`, `usrm_password`, `usrm_phone`, `usrm_email`, `usrm_updated`, `usrm_approved`, `usrm_usrtype`, `usrm_profilepic`, `usrm_no`, `usrm_gender`, `usrm_Qualification`, `usrm_dob`, `sentNotify`, `categoryID`, `availableReview`, `availableReviewComment`) VALUES
(192, 'Ameede Faith ', 'Makerere University ', 'Faith ', 'Ameede', 3, '84048566d653137cd93377b4361a8157', '+256780761738', 'fameede89@gmail.com', '2019-10-14 11:21:41', 1, 'user', '', '', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(193, 'jonathan', 'Uganda National Council for Science And technology', 'Jonathan', 'Lwanga', 3, 'ae6cffd8b831706cd615b4bfa457373c', '0790273007', 'lwangajonathan@students.vu.ac.ug', '2019-10-14 12:31:43', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(194, 'BrendaExcup', 'BrendaExcup', 'BrendaExcup', 'BrendaExcup', 0, 'e3c2521d658543d9bd4bc5477c8b85ea', '86285352157', 'brendafruch@topazpro.xyz', '2019-10-14 14:38:35', 1, 'user', '', '', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(195, 'Tobby', 'Otuke District Local Government', 'Tobby Michael', 'Agwe', 3, '55b98dfad29c7446c97a1bff1c2a621c', '0777111870', 'amtobby2014@gmail.com', '2019-10-15 07:04:50', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(196, 'pauldanquah', 'CSIR-INSTI', 'Paul ', 'Danquah', 0, 'e27fa04b42acf1cab8bcc2eea5ed21b7', '0243784082', 'pauldanquah@yahoo.com', '2019-10-15 07:16:26', 0, 'user', '', '', '', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(197, 'Mubita', 'National Science and Technology Council', 'Mubita', 'Simataa', 118, 'dc2001886c9669ed451dd19bd908df35', '+260978612960', 'mubitasimataa22@gmail.com', '2019-10-15 07:13:52', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(198, '1111111111', 'CSIR-INSTI', 'Paul', 'Danquah', 3, 'e27fa04b42acf1cab8bcc2eea5ed21b7', '0243784082', 'pauldanquah@yahoo.com', '2019-10-15 07:25:20', 1, 'user', '', '', '', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(199, 'rachealnabwire', 'national fisheries resources research institute', 'Racheal', 'Nabwire', 3, 'b7076337a7b6e3b83a5defcfb27d3741', '+256781357419', 'nabwireracheal6@gmail.com', '2019-10-16 07:03:30', 0, 'user', '', '7df257b89b77b807058e572523961c09', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(200, 'dennismale', 'Uganda Industrial Research Institution', 'Dennis', 'Male-Sebuliba', 3, '62cb5fcbbb8acc04049984a300be77ad', '+256772200737', 'dennismale@gmail.com', '2019-10-16 13:30:16', 0, 'user', '', '44774808caf725df96ca2e7d126dc5f1', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(201, 'Doreen', 'Makerere University, Kampala Uganda', 'Asienzo', 'Ampumuza Doreen', 0, '8bc7d085b5b0ca65310a2b30437c4f81', '0774494000', 'asienzodoreen@gmail.com', '2019-10-21 06:37:00', 0, 'user', '', '2aac52a6d5eb012fe0c83e61531fe1d2', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(202, 'Ssembuusi Ignatius', 'Kyambogo University', 'Ssembuusi', 'Ignatius', 3, '2de780f32b5a3224f15d65d7be805b76', '0704896588', 'rotiusangelssalonsafrica1@gmail.com', '2019-10-21 13:12:39', 0, 'user', '', '4b1a5d96da1d30e3a39467b5359cef5a', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(203, 'Ssembuusi', 'Kyambogo University', 'Ssembuusi', 'Ignatius', 0, 'a68b40973eb8c25420025d09e7210d9e', '0704896588', 'rotiusangelssalonsafrica1@gmail.com', '2019-10-21 13:12:39', 0, 'user', '', '4b1a5d96da1d30e3a39467b5359cef5a', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(204, 'trevk', 'THE good currency', 'TREVOR', 'KYAKULUMBYE', 3, '2024592242e071ed754722f4f81ebb6d', '0779198336', 'goodcurrency@gmail.com', '2019-10-25 10:43:25', 0, 'user', '', 'e5298d2a9d953c9fe038c31bd7ca4dff', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(205, 'ktrevor2', 'THE GOOD CURRENCY', 'TREVOR', 'KYAKULUMBYE', 3, '2024592242e071ed754722f4f81ebb6d', '0779198336', 'goodcurrency2019@gmail.com', '2019-10-25 10:51:47', 0, 'user', '', '38865e46fb85fce8e4579ff588daa48a', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(206, 'Mmwandaless2009@gmail.com', 'National Agricultural Research Organisation', 'Wanda', 'Fred-Masifwa', 3, '2d42493c27dbd5746b7dff2521bad020', '+256755795355', 'Mmwandaless2009@gmail.com', '2019-10-31 09:36:35', 0, 'user', '', '19d17ccccf6edf94034265c0ea58aed6', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(207, 'Lemmy', 'none', 'Thorach Lemmy', 'Daizy', 3, 'f8217de91e129f7b529d31b2112ded20', '256775304582', 'lemmydaizy05@gmail.com', '2019-10-31 13:36:42', 1, 'user', '', '', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(208, 'katiti', 'KYAMBOGO UNIVERSITY', 'KATITI', 'JOSEPH NGABIRANO', 3, '7c2d9f6e0bc600fb81e821e23036e10f', '0789769246', 'katitijoseph@gmai.com', '2019-11-01 12:59:11', 0, 'user', '', 'a276f312c206220e031f57f92b1c229b', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(209, 'kjjn', 'KYAMBOGO UNIVERSITY', 'KATITI', 'JOSEPH NGABIRANO', 3, '7c2d9f6e0bc600fb81e821e23036e10f', '0789769246', 'katitijoseph@gmail.com', '2019-11-01 13:08:10', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(210, 'kirundafahad', 'bugiri district local government', 'FAHAD', 'KIRUNDA', 3, 'c388f76227c69ccd340f79f0e19f6657', '0787485263', 'kirundafahad@gmail.com', '2019-11-01 17:47:01', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(211, 'gbamuhimbise', 'Makerere University', 'Bamuhimbise', 'Gilbert', 3, 'c1c13618148713b1d5b6ce9d7c77b8f1', '+256772155726', 'gbamuhimbise@cedat.mak.ac.ug', '2019-11-04 10:57:29', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(212, 'odyomoj', 'Currently working with Exquisite solutions LTD', 'James', 'Odyomo', 3, '10f36b66b42e585984a05bc51e0cc776', '0774487305', 'odyomoj@gmail.com', '2019-11-05 10:45:40', 0, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(213, 'odyomoj@gmail.com', 'Currently working with exquisite ltd', 'James', 'Odyomo', 3, '10f36b66b42e585984a05bc51e0cc776', '0774487305', 'odyomoj@gmail.com', '2019-11-05 10:45:40', 0, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(214, 'RonaldK', 'Lansult Technologies/Proptech Uganda', 'Ronald ', 'Kaweesi', 0, '78ce172f7179ec95575b54b78f2dceee', '+256774522035', 'kwsronald7@gmail.com', '2019-11-05 16:55:28', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(215, '16bsubns043', 'Bishop Stuart University', 'BYARUHANGA', 'VICENSIO', 3, 'd0281ff4195a0dac96979e40ba7784be', '0752180351/0789304246', 'byaruhangavicensio200@gmail.com', '2020-08-12 19:39:49', 0, 'user', '', '05367eb1567d5a8a6f197b506cc876b1', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(216, 'Scott B', 'Information Technology ', 'Scott', 'Businge', 0, 'c816b5b72d25f0acd3194a5b6584c078', '0772763982 ', 'busingescott@gmail.com', '2020-08-14 09:47:17', 0, 'user', '', '039f66776a04473a10c06c2522e24ac6', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(217, 'makayimark', 'Islamic university in Uganda', 'MAKAYI', 'MARK', 3, 'b2556e5f1e588b4f7afb008158f28de6', '256701908312', 'makayimark600@gmail.com', '2020-08-15 19:00:10', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(218, 'MAURICEAYEBAZIBWE', 'MAKERERE UNIVERSITY', 'MAURICE', 'AYEBAZIBWE', 0, '05f4b08c5a1fd65baabeefe3bb72ca63', '0757829599', 'ayebazibwemaurice1@gmail.com', '2020-08-19 11:26:06', 1, 'user', '', '', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(219, 'atumukunde', 'Bio-Innovations Company Ltd', 'Alex', 'Tumukunde', 3, 'e39126287f39e098edc6b707c52a316d', '+256779125508', 'alex.tumukunde@gmail.com', '2020-08-19 14:03:40', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(220, 'bethnanyama', 'MAKERERE UNIVERSITY', 'BETH', 'NANYAMA', 3, '134deef259afaa602649573e3996ec4d', '+256-701488252', 'bethnanyamaa@gmail.com', '2020-08-24 09:00:42', 1, 'user', '', '', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(221, 'jonans2020', 'Mbarara University of Science and Technology', 'Jonans', 'Tusiimire', 3, 'a7fc93194cc0a758a0aaa108249bd0ed', '0774521094', 'jonanstusiimire@gmail.com', '2020-09-16 11:59:29', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(222, 'JTusiimire2020', 'Mbarara University of Science and Technology', 'Jonans', 'Tusiimire', 3, 'a7fc93194cc0a758a0aaa108249bd0ed', '0774521094', 'jonanstusiimire@gmail.com', '2020-09-16 12:05:47', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(223, 'gtumwine', 'Department of Food Technology & Nutrition, Makerere University', 'Gerald ', 'Tumwine', 3, 'eabb4cc73dbf61ef958935dafab7c5ba', '+256700590401', 'tgerald111@gmail.com', '2020-09-18 11:41:37', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(224, 'Jamesomongot', 'Transformative Project services', 'James', 'Omongot', 3, '9092f46ab7c8c057db70762299380c41', '+256781807887', 'jamesomongot60@gmail.com', '2020-09-19 14:54:57', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(225, 'agabanelson', 'Nelson Leather Works', 'Nelson', 'Agaba', 3, '1148a82ed492a52670373cd21b33f8f3', '+256753483747', 'agabanelson@gmail.com', '2020-09-23 05:04:08', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(226, 'gssepuuya', 'Uganda Christian University', 'Geoffrey', 'Ssepuuya', 3, '24cf16783657984ca525b2a5beda6c30', '+256-783451770', 'gssepuuya@ucu.ac.ug', '2020-09-24 22:07:32', 1, 'user', '', 'd948194fb890aa892bcb7e384f8c529f', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(227, 'Wacooalex', 'Makererere University', 'Alex', 'Wacoo', 3, 'ade8c425b5005efd14466caea503e4b4', '0776729748', 'pwacoo@chs.mak.ac.ug', '2020-09-24 15:45:12', 1, 'user', '', '', '', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(228, 'lhyz', 'School of public health,Makerere University college of health sciences', 'Betty', 'Nakabuye', 0, 'd0826d77ea459fd8fd40743d47f8b780', '+256774019751', 'lhyznk@gmail.com', '2020-09-25 07:43:12', 1, 'user', '', '', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(229, 'gksepuya@gmail.com', 'Uganda Christian University', 'Geoffrey', 'Ssepuuya', 3, '24375441e530af9cbccdba9736d83430', '0783451770', 'gksepuya@gmail.com', '2020-09-27 12:07:09', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(230, 'EKongai', 'Taita Taveta University', 'Esther', 'Kongai', 3, 'fe9033ce872197393814f5b1a8484e98', '+256775977388', 'jlykongai@gmail.com', '2020-10-05 08:27:36', 1, 'user', '', '', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(231, 'mj.baptist91@gmail.com', 'Crystal Clear Software LTD', 'JOHN', 'MUBANGIZI', 3, '4773eff54b29d8bdf18d0c760b1f7c86', '0774500408', 'mj.baptist91@gmail.com', '2020-10-05 08:18:07', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(232, 'YuSmile', 'Yu Smile Uganda', 'Allan David', 'Twinomujuni', 3, '7f8b64fbe7fce6bdd8e8b21430e76fb3', '+256782927639', 'yusmile.ug@gmail.com', '2020-10-05 09:29:23', 0, 'user', '', 'c36ae4244fa75ad525e26d7709a64f5e', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(233, 'catherine', 'Uganda Christian University', 'catherine', 'Atuheise', 3, 'cfd9cbc5d91180c703ac0b2d168916ce', '+256750431961/ +256787339656', 'catuheise@gmail.com', '2020-10-08 09:06:26', 1, 'user', '', '', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(234, 'jkalanga@safri.ac.ug', 'Sanyu Africa Research Institute', 'Patrick', 'Kalanga', 3, 'd2a9e4940dbe68c65a9abb2e1044af4b', '0782086452', 'jkalanga@safri.ac.ug', '2021-04-15 11:27:58', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(235, '@ahumuzafortun', 'Makerere University', 'Fortunate ', 'Ahumuza', 3, '376491ed327453f858c97bbe5d145caf', '0775561126', 'ahumuzafortunate03@gmail.com', '2020-10-14 12:23:35', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(236, 'ekaweesi', 'UGANDA HOTEL AND TOURISM TRAINING INSTITUTE, JINJA ', 'KAWEESI', 'EMMANUEL', 3, 'ab97af210877f2fa78199dc4d9e90cee', '0753585908 / 0773800666', 'kaweesiemma2000@gmail.com', '2020-10-15 16:52:39', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(237, 'spirumaisha', 'Spirumaisha Uganda Limited', 'khamisi', 'Musanje', 3, '2b5484130675b5db8cd01d4fbbdd386a', '+33634964853', 'Spirumaisha@gmail.com', '2020-10-16 16:37:44', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(238, 'dturyamureeba', 'MBARARA UNIVERSITY OF SCIENCE AND TECHNOLOGY', 'DAVID', 'TURYAMUREEBA', 3, '6b8204749a205fed95bb6cc2e63288fa', '256779423836', 'rutaraka.david4@gmail.com', '2020-10-18 12:25:01', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(239, 'Talutambudde', 'Pearl Health Informatics Consult', 'isaac', 'kabuye', 3, '1373883b4f087bed5915cf82278d305f', '0700941738', 'goldentalutex@gmail.com', '2020-10-20 10:33:05', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(240, 'Humphrey', 'Bishop Stuart university', 'Humphrey', 'Atwijukiire', 3, '989480633d4c014898866047240d3ab4', '0775131535', 'atwijukiireh@gmail.com', '2020-10-27 09:45:48', 0, 'user', '', 'ef1dc6362882c571fce3d3d176fcc2e3', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(241, 'aruhogsdickson', 'Makerere University', 'Dickson', 'Aruhomukama', 3, 'c19b30edce7dc0e82cee21fe7ff52ba2', '+256706511287', 'dickson.aruhomukama@chs.mak.ac.ug', '2020-11-04 09:31:36', 0, 'user', '', '50abed8355fcd4cf4880509ced71889c', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(242, 'Mckenzie', 'Mbarara University of Science and Technology', 'Tuhirirwe', 'Mackenzie', 3, '7260bc5a40d2ac08340d3cc9e01aca75', '+256700760978', 'tmackenzie@must.ac.ug', '2020-11-06 14:10:04', 0, 'user', '', '10db878b15e40ee88e2ad3feed8a881b', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(243, 'Mackenzie', 'Mbarara University of Science and Technology', 'Tuhirirwe', 'Mackenzie', 3, '7260bc5a40d2ac08340d3cc9e01aca75', '+256700760978', 'tmackenzie@must.ac.ug', '2020-11-06 14:15:04', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(244, 'Erion Bwambale', 'Busitema University', 'Erion', 'Bwambale', 3, '5c3ec94457d9196ed39f8c72b35200f3', '+256776800417', 'erionbwambs20@gmail.com', '2020-11-06 14:55:05', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(245, 'Davies', 'Copperbelt University', 'Davies', 'Wambwa', 3, '50ae3ed0e09415823d3f52de6b1f2021', '+256776596498', 'dwambwa@yahoo.com', '2020-11-10 22:01:09', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(246, 'africaorganization.ug@gmail.com', 'Africa Light organization for Relief and Development-ALFORD', 'Odyomo', 'Godfrey', 3, '14b61d242ab90d52885a757f062fad3e', '0770317810', 'africaorganization.ug@gmail.com', '2020-12-09 07:18:51', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(247, 'enospenington', 'kyambogo university', 'muwanga enos', 'enos', 3, 'ba3d619b049bd73d776dab775a00ceee', '+256705413842', 'enospenington@gmail.com', '2020-11-13 21:08:03', 0, 'user', '', '7078da44e361a7a26d455fd25c713190', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(248, 'Tibyangye', 'Muni University', 'Julius', 'Tibyangye', 3, '3937ad6954de99672e3e79b974a6f385', '0782683182', 'j.tibyangye@muni.ac.ug', '2020-11-20 09:42:57', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(249, 'tambuladigitalmedia', 'Tambula Digital Media', 'Phillip', 'Lubanga', 3, '8870c9e4bdbefe0530bce9123f417bc3', '0780717630', 'phillip@tambulamedia.com', '2020-11-26 10:18:49', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(250, 'TDMedia', 'Tambula Digital Media', 'Phillip', 'Lubanga', 3, '8870c9e4bdbefe0530bce9123f417bc3', '0780717630', 'phillip@tambulamedia.com', '2020-11-26 10:18:49', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(251, 'Glo Invetions', 'Glo Inventions Uganda Limited', 'Apio Gloria', 'Gladys', 3, '516909e4dfe09d4aa9ee8eb87d4f0e3c', '0759492817', 'gloinventions.uganda@gmail.com', '2020-12-01 11:04:53', 1, 'user', '', '', 'Female', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(252, 'bchemayek', 'National Agricultural Research Organisation, Buginyanya ZARDI', 'Bosco', 'Chemayek', 3, '89c99482edb468a2eb9814f6b1380979', '+256776986674', 'bchemayek@gmail.com', '2020-12-10 07:34:07', 1, 'user', '', '', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(253, 'George Kimbowa', 'Busitema University', 'GEORGE', 'KIMBOWA', 3, '3319bdc5fdc76f0d7a697c3cc99026b0', '+256777683435', 'georg.kimb@gmail.com', '2020-12-16 13:20:54', 1, 'user', '', '882a95020b7eb65410d5b2ec4d419822', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(254, 'rukundo17', 'Mbarara University of Science and Technology', 'Isaac', 'Rukundo', 3, 'e548e0dcff55ecb16b3a24560dbea529', '+256784599270', 'rukundo17@gmail.com', '2020-12-17 21:20:37', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(255, 'kimuliedson', 'Filotimoconsult', 'Kimuli', 'Edson Paul', 0, '957286e5894746072cf9cdaa25372b3f', '+256757283677', 'edsonkimuli@gmail.com', '2021-01-04 21:56:31', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(256, 'Atwine', 'SOAR RESEARCH FOUNDATION', 'DANIEL', 'ATWINE', 3, '3306b9c9df22c316cf3cd751029e49d9', '+256 759542376', 'adaniel_joshua@yahoo.co.uk', '2021-01-11 14:17:35', 0, 'user', '', 'e1c37a9f31b57cce9c5ca19478b7ab9a', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(257, 'MicroF', 'Partner', 'Bagio', 'Anyoli', 3, 'dbf401600d57fcc698748b8e93c2b694', '0775415088', 'bagzitoni@gmail.com', '2021-01-26 15:09:10', 1, 'user', '', '', '', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(258, 'digitaldiva', 'Hive Colab', 'Barbara', 'Mutabazi', 3, '1ab856c1e702919f5c92e1d5aaad82f5', '782861382', 'birungibarbs@gmail.com', '2021-01-27 17:33:51', 1, 'user', '', '', 'Female', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(259, 'OmY', 'Mbarara University of Science and Technology', 'GODFREY', 'OMAIDI', 3, '17eac0801540ec6db59ec26016b3fa1c', '0788263121', 'godfreyomaidi999@gmail.com', '2021-02-09 15:27:58', 0, 'user', '', '47ebfec79580a4a189365fbcfb1a84c4', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(260, 'Joel Ssendi', 'Uganda Biotechnology and Biosafety Consortium ', 'Joel', 'Ssendi', 3, '0b36924be0aa7a9711f1de6816f0ac75', '+256705437623', 'jssendi998@gmail.com', '2021-02-12 09:19:55', 0, 'user', '', 'd42478fe5ec3c085a835a292089d7fea', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(261, 'jssendi', 'Uganda Biotechnology and Biosafety Consortium ', 'Joel', 'Ssendi', 3, '0b36924be0aa7a9711f1de6816f0ac75', '+256705437623', 'jssendi998@gmail.com', '2021-02-12 09:20:59', 0, 'user', '', 'd42478fe5ec3c085a835a292089d7fea', '', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(262, 'umi', 'Uganda Management Institute', 'Komakech', 'Robert Agwot', 3, '461b257b9d1710169bae57864a88e744', '0774181052', 'kagwot@gmail.com', '2021-02-19 12:19:01', 0, 'user', '', '084f10ef64ddb3937c1921709e8ff8f0', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(263, 'Daka', 'Kampala Capital City Authority', 'Daka', 'Anthony', 3, 'cbdeb56ae42d397deac5985980306781', '0784780324', 'dakaanthony84@gmail.com', '2021-02-23 07:52:35', 0, 'user', '', '5582151e01c7be619abe870f38f508f9', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(264, 'bujopa29', 'bujopa Industries', 'John', 'Buyondo', 3, '49a36710382c7774433d734e44fbca7d', '3154207074', 'buyondo2@gmail.com', '2021-02-27 19:03:17', 0, 'user', '', 'e74e873b573c5f7689c2e454fa8be1e1', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(265, 'NNIYONZIMA', 'Uganda Cancer Institute ', 'NIXON', 'NIYONZIMA', 3, '6838b0e70bcb161923971fc8106fc32b', '755677395', 'nniyonzima@gmail.com', '2021-03-04 12:34:40', 0, 'user', '', '77db7ae8afc96fd24c9a5d3304bd4c5b', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(266, 'johnlubinga92', 'Nkwanzi Resources Development Ltd ', 'Lubinga ', 'John ', 3, '581805180d27e775b056c06ba55c7914', '0782333818', 'johnlubinga92@gmail.com', '2021-03-15 10:10:57', 0, 'user', '', '8a6d79e6adee1a83242c45a8d78bd7d5', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(267, 'jtabuti', 'Makerere University', 'John', 'Tabuti', 3, 'f5ff1350e470534c7dde5d1a0f69560f', '+256772960880', 'jtabuti@gmail.com', '2021-03-22 17:21:23', 0, 'user', '', '4720d835389a779452c823e802676e1e', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(268, 'Dean_Ndejje', 'Ndejje University ', 'Robert', 'Setekera', 3, 'e2e1dad8bcd468f995db50401f5e0fa4', '0751855207', 'rsetekera@gmail.com', '2021-03-29 07:48:42', 0, 'user', '', 'ca0810896fea964fbf900707c19f574e', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(269, 'sojelel', 'Makerere University', 'Samuel', 'OJELEL', 3, '520c900ef361be266d36912e2f593843', '0772188705', 'samuel.ojelel@mak.ac.ug', '2021-03-29 14:04:22', 0, 'user', '', '7a05754af282f3c7566c348cebf5ace6', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(270, 'Dailyforestry', 'Bangor University', 'Saul', 'Ndyabandiho', 3, '12dd09e349f8aef6d4122e3f83ece0f0', '+256 785971913', 'nssndaba49@gmail.com', '2021-04-01 12:05:13', 0, 'user', '', '2ef6a0a5742415dfee99e1401c6aa510', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(271, 'dkiberu', 'JODES Grants Management Agency', 'Deogratius', 'Kiberu', 0, '6e331aa3e14548801be4d69d169d4b38', '+256 752829024', 'dkiberu@jodes.org', '2021-04-06 09:01:50', 0, 'user', '', 'ae1bfa2e1108993275d4996bc704469b', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(272, 'SWIDIQ', 'National Agricultural Research Organisation ', 'SWIDIQ', 'MUGERWA', 3, 'd8db2a44049e918d90dc57095a5e1a09', '+256782660295', 'mugerwaswidiq@gmail.com', '2021-04-12 05:48:17', 0, 'user', '', 'c1c9469b264ffca9b937d415837cd415', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(273, 'wolahomukani', 'COVAB-Makerere University', 'William ', 'Olaho-Mukani', 0, '2f655fd3bc953582abd85e452f7a7588', '+2540784275139', 'williamolahomukani@gmail.com', '2021-04-12 10:05:21', 0, 'user', '', 'd85fc499bc0f547fb33696d78d2e4d44', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(274, 'williamolahomukani', 'COVAB-Makerere University', 'William ', 'Olaho-Mukani', 0, '2f655fd3bc953582abd85e452f7a7588', '+2540784275139', 'williamolahomukani@gmail.com', '2021-04-12 10:10:08', 0, 'user', '', 'd85fc499bc0f547fb33696d78d2e4d44', '', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(275, 'admin01', 'Ndjdjd', 'Bdjdjd', 'Hdjd', 26, '5d38c2bcef8326526afbb48c8bd18aba', '0845644444646', 'bocilf36@gmail.com', '2021-04-12 15:48:18', 0, 'user', '', 'c52b5670a0109a104c9c405f2d988d77', 'Female', 'Diploma', '0000-00-00', 'No', '', 'notknown', ''),
(276, 'gkamuleg', 'Makerere University Kampala', 'Kamulegeya', 'Grace', 3, '15471bf60afa66f3a60c80ffedac14fb', '0756100946', 'gkamulegeya@cis.mak.ac.ug', '2021-04-13 09:09:05', 0, 'user', '', '1e1fbbb2064f6173cf1d799a23c51652', 'Male', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(277, 'msaimo', 'Makerere University', 'Margaret', 'Kahwa', 3, 'f1e5838e18b75e3b7f72f7747a5b49d8', '0772592736', 'msaimok@gmail.com', '2021-04-14 13:48:12', 0, 'user', '', 'ec11475e351960de4a009c5fb54119f8', 'Female', 'PHD', '0000-00-00', 'No', '', 'notknown', ''),
(278, 'osbertmuganga@btigroup.com', 'Build2gether investments (u) ltd', 'Osbert', 'Muganga', 3, 'e91d6f89f435978402f38a8904ce8eae', '0778830982', 'osbertmuganga@btigroup.com', '2021-04-14 14:42:36', 0, 'user', '', '892f57c1a7fad7375ac102efec194249', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(279, 'snopunks123', 'jln', 'snopunks', 'snopunks', 22, 'd72049cd4dc1bbd80d564878c10ddd69', '9494919184848', 'snopunks@gmail.com', '2021-04-14 19:46:33', 0, 'user', '', '9fe6a324572f42692744930fed644188', '', 'Other', '0000-00-00', 'No', '', 'notknown', ''),
(283, 'mmmawanda@safri.ac.ug', 'Sanyu Africa Research Institute (SAfRI)', 'Moses', 'Mawanda', 3, '913619e58f80a548bccc6c6a1ce1b1b4', '0782086452', 'mmmawanda@safri.ac.ug', '2021-05-09 12:19:10', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(284, 'emwesigye', 'UNCST Ntinda Kampala', 'Mwesigwa', 'Collins', 3, 'ff48a2def4afa3a7ebb11182fa3de9a6', '0752807890', 'evanmwesigye@gmail.com', '2021-04-16 05:59:47', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(285, 'Howard', 'National Agriculture Research Organisation', 'KASIGWA', 'NELSON', 3, '5b1fdcbbfc35b7f9b3cb3cee4c1aeabb', '0772668532', 'hkasigwa@gmail.com', '2021-04-22 07:59:24', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(286, 'nrims4narc', 'Test Grants April', 'Test1', 'Grants', 119, '31183f1b50427c08175deda0d96a7f7e', '0701228872', 'nrims4narc@gmail.com', '2021-05-05 05:54:59', 1, 'user', '', '', 'Male', 'Bachelor\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(287, 'mmawanda@safri.ac.ug', 'Uganda National Council', 'Moses', 'Mawanda', 3, '913619e58f80a548bccc6c6a1ce1b1b4', '0781293993', 'mmawanda@safri.ac.ug', '2021-06-16 12:27:25', 1, 'user', '', '', 'Male', 'Master\'s Degree', '0000-00-00', 'No', '', 'notknown', ''),
(288, 'Wantsusi', 'National Agricultural Research Organization (NARO)', 'Godwin Michael', 'Wantsusi', 3, '1cbcff6f3d410ec284ccead81a13a4e4', '+256774139445', 'gmwantsusi@gmail.com', '2021-05-27 10:35:40', 1, 'user', '', '', 'Male', 'Master\'s Degree', '1963-05-05', 'No', '', 'notknown', '');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_pages`
--

CREATE TABLE `ppr_pages` (
  `id` int(11) NOT NULL,
  `section` enum('top','innerpage') NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_possible_risk`
--

CREATE TABLE `ppr_possible_risk` (
  `id` int(255) NOT NULL,
  `projectmgtID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `PossibleRisk` text NOT NULL,
  `MitigationMeasure` text NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_potential_for_synergy`
--

CREATE TABLE `ppr_potential_for_synergy` (
  `id` int(11) NOT NULL,
  `methodologyID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `SynergyProject` varchar(255) NOT NULL,
  `SynergyTask` varchar(255) NOT NULL,
  `SynergyDescrption` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_principal_investigators`
--

CREATE TABLE `ppr_principal_investigators` (
  `piID` int(255) NOT NULL,
  `conceptm_id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `Surname` varchar(255) DEFAULT NULL,
  `Othername` varchar(150) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `AgeRange` varchar(100) DEFAULT NULL,
  `Contacts` varchar(150) DEFAULT NULL,
  `Expertise` varchar(255) DEFAULT NULL,
  `EducationalBackground` varchar(255) DEFAULT NULL,
  `Qualifications` varchar(255) DEFAULT NULL,
  `ResearchExperience` varchar(255) DEFAULT NULL,
  `ResearchExperienceDetails` longtext NOT NULL,
  `RoleofTeamMember` varchar(100) DEFAULT NULL,
  `InstitutionofAffiliation` varchar(255) NOT NULL,
  `updatedon` datetime NOT NULL,
  `is_sent` int(11) NOT NULL,
  `catNormal` enum('static','dynamic') NOT NULL DEFAULT 'static'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_principal_investigators`
--

INSERT INTO `ppr_principal_investigators` (`piID`, `conceptm_id`, `owner_id`, `Surname`, `Othername`, `Gender`, `AgeRange`, `Contacts`, `Expertise`, `EducationalBackground`, `Qualifications`, `ResearchExperience`, `ResearchExperienceDetails`, `RoleofTeamMember`, `InstitutionofAffiliation`, `updatedon`, `is_sent`, `catNormal`) VALUES
(1, 1, 287, 'Test Project1', 'Project1', 'Male', '31-40', '0784567890', 'Looking after MM', '', '', 'Yes', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Principal Investigator', 'Uganda Matrys Univ', '2021-06-17 14:58:32', 0, 'dynamic'),
(2, 1, 287, 'James', 'Tim', 'Female', '21-30', '372473573475', 'nsandsnfnsdnf', '', '', 'No', '', 'Co-Investigator', 'hwrhwehrhehr', '2021-06-17 15:37:59', 0, 'dynamic'),
(3, 1, 287, 'Admin4', 'MM', 'Male', '71-80', '08866766666', 'Insects', '', '', 'Yes', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Principal Investigator', 'Makai College', '2021-06-17 15:48:22', 0, 'dynamic');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_progress_meeting_abstracts`
--

CREATE TABLE `ppr_progress_meeting_abstracts` (
  `meetingAbstractID` int(255) NOT NULL,
  `progressID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `chapters` text NOT NULL,
  `NameofMeeting` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `MeetingDate` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_progress_report_keypersonnel_effort`
--

CREATE TABLE `ppr_progress_report_keypersonnel_effort` (
  `id` int(255) NOT NULL,
  `progressID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `PIName` varchar(150) NOT NULL,
  `RoleinProject` varchar(255) NOT NULL,
  `MonthsDevotedtoProject` varchar(255) NOT NULL,
  `Changesinrole` varchar(255) NOT NULL,
  `Dateofchange` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_progress_report_otherpresentations`
--

CREATE TABLE `ppr_progress_report_otherpresentations` (
  `id` int(255) NOT NULL,
  `progressID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `Organization` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `DateofMeeting` int(11) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_progress_report_review`
--

CREATE TABLE `ppr_progress_report_review` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `progressID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `SignaturePage` int(11) NOT NULL,
  `Abstract` int(11) NOT NULL,
  `SummaryofScientificProgress` int(11) NOT NULL,
  `KeyPersonnelEffort` int(11) NOT NULL,
  `Publications` int(11) NOT NULL,
  `PatentsandLicenses` int(11) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'new',
  `reviewer_id` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_progress_report_signature_page`
--

CREATE TABLE `ppr_progress_report_signature_page` (
  `progressID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectQuarter` varchar(20) NOT NULL,
  `reportType` enum('QuarterlyProgressReport','FinalReport') NOT NULL DEFAULT 'QuarterlyProgressReport',
  `Institution` varchar(255) NOT NULL,
  `InstitutionAddress` varchar(255) NOT NULL,
  `InstitutionTelephone` varchar(100) NOT NULL,
  `InstitutionEmail` varchar(255) NOT NULL,
  `InstitutionWebsite` varchar(255) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `reportStatus` enum('Pending','Approved','Rejected','Fowarded','Scheduled for Review','Submitted') NOT NULL DEFAULT 'Pending',
  `submissionDate` datetime NOT NULL,
  `briefoverview` text NOT NULL,
  `degree_stated_project` text NOT NULL,
  `barriers` text NOT NULL,
  `summarymajorAccomplishments` text NOT NULL,
  `plansforContinuation` text NOT NULL,
  `rejectReasons` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_progress_report_stages`
--

CREATE TABLE `ppr_progress_report_stages` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `progressID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `SignaturePage` int(11) NOT NULL,
  `Abstract` int(11) NOT NULL,
  `SummaryofScientificProgress` int(11) NOT NULL,
  `KeyPersonnelEffort` int(11) NOT NULL,
  `Publications` int(11) NOT NULL,
  `PatentsandLicenses` int(11) NOT NULL,
  `status` enum('new','old') NOT NULL DEFAULT 'new'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_progress_report_summary_progress`
--

CREATE TABLE `ppr_progress_report_summary_progress` (
  `id` int(255) NOT NULL,
  `progressID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `patentlicense` enum('No','Yes') NOT NULL DEFAULT 'No',
  `listofallpatents` text NOT NULL,
  `nameofthepatent` text NOT NULL,
  `potentialimportance` text NOT NULL,
  `detailed_account_progress` text NOT NULL,
  `listeachspecificaim` text NOT NULL,
  `anyaimsdiscontinued` text NOT NULL,
  `newnovelfindings` text NOT NULL,
  `majorresearchmilestones` text NOT NULL,
  `nextQuarterResearchGoals` text NOT NULL,
  `is_sent` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_projects_objectives`
--

CREATE TABLE `ppr_projects_objectives` (
  `id` int(255) NOT NULL,
  `methodologyID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectName` text NOT NULL,
  `projectObjectives` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_background`
--

CREATE TABLE `ppr_project_background` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `SummaryAudience` text NOT NULL,
  `explanationObjectives` text NOT NULL,
  `researchInnovationIssues` text NOT NULL,
  `NovelCharacterScientificResearch` text NOT NULL,
  `ClearJustificationDemonstration` text NOT NULL,
  `interdisciplinaryTransdisciplinary` text NOT NULL,
  `addedValue` text NOT NULL,
  `ImportanceResearchInnovation` text NOT NULL,
  `PartofInternationalProject` enum('No','Yes') NOT NULL DEFAULT 'No',
  `projectSpecificActivities` text NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_budget`
--

CREATE TABLE `ppr_project_budget` (
  `id` int(11) NOT NULL,
  `Personnel` double NOT NULL,
  `PersonnelTotal` double NOT NULL,
  `ResearchCosts` double NOT NULL,
  `ResearchCostsTotal` double NOT NULL,
  `Equipment` double NOT NULL,
  `EquipmentTotal` double NOT NULL,
  `kickoff` double NOT NULL,
  `kickoffTotal` double NOT NULL,
  `Travel` double NOT NULL,
  `TravelTotal` double NOT NULL,
  `KnowledgeSharing` double NOT NULL,
  `KnowledgeSharingTotal` double NOT NULL,
  `OverheadCosts` double NOT NULL,
  `OverheadCostsTotal` double NOT NULL,
  `OtherGoods` double NOT NULL,
  `OtherGoodsTotal` double NOT NULL,
  `MatchingSupport` double NOT NULL,
  `MatchingSupportTotal` double NOT NULL,
  `TotalBudget` double NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `projectID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_details_concept`
--

CREATE TABLE `ppr_project_details_concept` (
  `id` int(255) NOT NULL,
  `Methodology` longtext NOT NULL,
  `solution` text NOT NULL,
  `SpecialInterestGroup` text NOT NULL,
  `PartnershipsCollaborations` text NOT NULL,
  `ExpectedIntellectualProperty` varchar(255) NOT NULL,
  `PrimaryFunderName` varchar(255) NOT NULL,
  `PrimaryFunderAmount` varchar(100) NOT NULL,
  `SecondaryFunderName` varchar(255) NOT NULL,
  `SecondaryFunderAmount` varchar(100) NOT NULL,
  `CounterpartFundingName` varchar(255) NOT NULL,
  `CounterpartFundingAmount` varchar(100) NOT NULL,
  `currencyPrimaryFunder` varchar(11) NOT NULL,
  `currencySecondaryFunder` varchar(11) NOT NULL,
  `currencyCounterpartFunding` varchar(11) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `TotalBudget` double NOT NULL,
  `PrimaryFunderDuration` varchar(255) NOT NULL,
  `SecondaryFunderDuration` varchar(255) NOT NULL,
  `CounterpartFundingDuration` varchar(255) NOT NULL,
  `periodPrimaryFunder` varchar(8) NOT NULL,
  `periodSecondaryFunder` varchar(8) NOT NULL,
  `periodCounterpart` varchar(8) NOT NULL,
  `catNormal` enum('static','dynamic') NOT NULL DEFAULT 'static'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_follow_up`
--

CREATE TABLE `ppr_project_follow_up` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `resultExploitationPlan` longtext NOT NULL,
  `resultInnovativeResults` longtext NOT NULL,
  `resultIntellectualProperty` longtext NOT NULL,
  `ethicalConsiderations` longtext NOT NULL,
  `DealwithEthicalIssues` longtext NOT NULL,
  `NeedEthicalClearance` varchar(10) NOT NULL,
  `NeedEthicalClearanceWhy` longtext NOT NULL,
  `GenderYouth` longtext NOT NULL,
  `YouthTakenccount` text NOT NULL,
  `YoungResearchers` text NOT NULL,
  `InterestGroups` text NOT NULL,
  `StateNatureofSupport` text NOT NULL,
  `AttachLetterofSupport` varchar(255) NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_management`
--

CREATE TABLE `ppr_project_management` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `overallCoordination` longtext NOT NULL,
  `GantChart` varchar(255) NOT NULL,
  `informationFlow` longtext NOT NULL,
  `RiskManagement` longtext NOT NULL,
  `PossibleRisk` text NOT NULL,
  `MitigationMeasure` text NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_methodology`
--

CREATE TABLE `ppr_project_methodology` (
  `methodologyID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `generalApproach` text NOT NULL,
  `RelationshipOngoingResearch` longtext NOT NULL,
  `otherDonorsFunding` varchar(10) NOT NULL,
  `StateDonors` text NOT NULL,
  `StateAmount` varchar(255) NOT NULL,
  `furtheringWork` varchar(10) NOT NULL,
  `furtheringWorkHow` text NOT NULL,
  `drawSynergiesOngoingProjects` varchar(10) NOT NULL,
  `projectone` text NOT NULL,
  `projectoneObjectives` text NOT NULL,
  `projectTwo` text NOT NULL,
  `projectTwoObjectives` text NOT NULL,
  `projectThree` text NOT NULL,
  `projectThreeObjectives` text NOT NULL,
  `potentialSynergyExist` text NOT NULL,
  `SynergyProject` text NOT NULL,
  `SynergyTask` text NOT NULL,
  `SynergyDescrption` text NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_methodology_donors`
--

CREATE TABLE `ppr_project_methodology_donors` (
  `id` int(11) NOT NULL,
  `methodologyID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `StateDonors` text NOT NULL,
  `StateAmount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_primary_beneficiaries`
--

CREATE TABLE `ppr_project_primary_beneficiaries` (
  `id` int(11) NOT NULL,
  `Categoryofbeneficiary` varchar(150) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Quantities` varchar(150) NOT NULL,
  `Locationofbeneficiaries` varchar(150) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `OthersCategory` varchar(255) NOT NULL,
  `OthersGender` varchar(255) NOT NULL,
  `catNormal` enum('static','dynamic') NOT NULL DEFAULT 'static'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_results`
--

CREATE TABLE `ppr_project_results` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `ResearchObjective` longtext NOT NULL,
  `Outputs` longtext NOT NULL,
  `Outcomes` longtext NOT NULL,
  `ImpactCapacityDevelopment` longtext NOT NULL,
  `ImpactPathwayDiagram` varchar(255) NOT NULL,
  `StakeholderEngagement` text NOT NULL,
  `CommunicationWithStakeholders` longtext NOT NULL,
  `ScientificOutput` text NOT NULL,
  `ResearchOutputs1` text NOT NULL,
  `ResearchOutputs2` text NOT NULL,
  `ResearchOutputs3` text NOT NULL,
  `ResearchOutputs4` text NOT NULL,
  `ResearchOutputs5` text NOT NULL,
  `ResearchOutputs6` text NOT NULL,
  `ResearchOutputs7` text NOT NULL,
  `ResearchOutputsIndicators1` text NOT NULL,
  `ResearchOutputsIndicators2` text NOT NULL,
  `ResearchOutputsIndicators3` text NOT NULL,
  `ResearchOutputsIndicators4` text NOT NULL,
  `ResearchOutputsIndicators5` text NOT NULL,
  `ResearchOutputsIndicators6` text NOT NULL,
  `ResearchOutputsIndicators7` text NOT NULL,
  `ResearchOutcomes1` text NOT NULL,
  `ResearchOutcomes2` text NOT NULL,
  `ResearchOutcomes3` text NOT NULL,
  `ResearchOutcomes4` text NOT NULL,
  `ResearchOutcomes5` text NOT NULL,
  `ResearchOutcomes6` text NOT NULL,
  `ResearchOutcomes7` text NOT NULL,
  `ResearchOutcomesIndicators1` text NOT NULL,
  `ResearchOutcomesIndicators2` text NOT NULL,
  `ResearchOutcomesIndicators3` text NOT NULL,
  `ResearchOutcomesIndicators4` text NOT NULL,
  `ResearchOutcomesIndicators5` text NOT NULL,
  `ResearchOutcomesIndicators6` text NOT NULL,
  `ResearchOutcomesIndicators7` text NOT NULL,
  `Impact1` text NOT NULL,
  `Impact2` text NOT NULL,
  `Impact3` text NOT NULL,
  `Impact4` text NOT NULL,
  `Impact5` text NOT NULL,
  `Impact6` text NOT NULL,
  `Impact7` text NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_project_stages`
--

CREATE TABLE `ppr_project_stages` (
  `id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `ProjectInformation` int(11) NOT NULL,
  `Background` int(11) NOT NULL,
  `Methodology` int(11) NOT NULL,
  `ProjectResults` int(11) NOT NULL,
  `ResearchTeam` int(11) NOT NULL,
  `ProjectManagement` int(11) NOT NULL,
  `Followup` int(11) NOT NULL,
  `Budget` int(11) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `PrincipalInvestigatorEducation` int(11) NOT NULL,
  `PrincipalInvestigatorResearch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_proposal_research_team`
--

CREATE TABLE `ppr_proposal_research_team` (
  `piID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `conceptm_id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `Surname` varchar(255) DEFAULT NULL,
  `Othername` varchar(150) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `AgeRange` varchar(100) DEFAULT NULL,
  `Contacts` varchar(150) DEFAULT NULL,
  `Expertise` varchar(255) DEFAULT NULL,
  `EducationalBackground` varchar(255) DEFAULT NULL,
  `Qualifications` varchar(255) DEFAULT NULL,
  `ResearchExperience` varchar(255) DEFAULT NULL,
  `ResearchExperienceDetails` longtext NOT NULL,
  `RoleofTeamMember` varchar(100) DEFAULT NULL,
  `InstitutionofAffiliation` varchar(255) NOT NULL,
  `updatedon` datetime NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_proposal_research_team_ext`
--

CREATE TABLE `ppr_proposal_research_team_ext` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `ConsultancyServices` text NOT NULL,
  `Recruitmentcapacity` text NOT NULL,
  `StateTheProjectAreas` text NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_request_for_funds`
--

CREATE TABLE `ppr_request_for_funds` (
  `id` int(11) NOT NULL,
  `Personnel` double NOT NULL,
  `PersonnelTotal` double NOT NULL,
  `ResearchCosts` double NOT NULL,
  `ResearchCostsTotal` double NOT NULL,
  `Equipment` double NOT NULL,
  `EquipmentTotal` double NOT NULL,
  `kickoff` double NOT NULL,
  `kickoffTotal` double NOT NULL,
  `Travel` double NOT NULL,
  `TravelTotal` double NOT NULL,
  `KnowledgeSharing` double NOT NULL,
  `KnowledgeSharingTotal` double NOT NULL,
  `OverheadCosts` double NOT NULL,
  `OverheadCostsTotal` double NOT NULL,
  `OtherGoods` double NOT NULL,
  `OtherGoodsTotal` double NOT NULL,
  `MatchingSupport` double NOT NULL,
  `MatchingSupportTotal` double NOT NULL,
  `TotalBudget` double NOT NULL,
  `TotalSubmitted` double NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectCategory` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `mainFunds_id` int(255) NOT NULL,
  `actionStatus` enum('Pending','Submitted','Rejected','Approved') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_request_for_funds_main`
--

CREATE TABLE `ppr_request_for_funds_main` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `ApprovedGrantTotal` varchar(255) NOT NULL,
  `BudgetItem` varchar(100) NOT NULL,
  `DescriptionofExpenditure` varchar(255) NOT NULL,
  `TotalCOST` varchar(100) NOT NULL,
  `BalanceonTotalBudget` varchar(150) NOT NULL,
  `dateRequested` datetime NOT NULL,
  `receivedBy` int(11) NOT NULL,
  `actionOnRequest` enum('Pending','Submitted','Approved','Rejected','Rejected with Comments') NOT NULL DEFAULT 'Pending',
  `requisitioning` enum('Partial Amount','Full Amount') NOT NULL DEFAULT 'Partial Amount',
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `currency` varchar(10) NOT NULL,
  `reason` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_request_for_procurement`
--

CREATE TABLE `ppr_request_for_procurement` (
  `id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `ApprovedGrantTotal` varchar(255) NOT NULL,
  `BudgetItem` varchar(100) NOT NULL,
  `DescriptionofExpenditure` varchar(255) NOT NULL,
  `TotalCOST` varchar(100) NOT NULL,
  `EstimatedUnitCost` varchar(100) NOT NULL,
  `BalanceonTotalBudget` varchar(150) NOT NULL,
  `dateRequested` datetime NOT NULL,
  `receivedBy` int(11) NOT NULL,
  `actionOnRequest` enum('Pending','Approved','Rejected','Rejected with Comments') NOT NULL DEFAULT 'Pending',
  `ProcurementPlanReference` varchar(255) NOT NULL,
  `LocationforDelivery` varchar(255) NOT NULL,
  `DateRequired` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_research_experience`
--

CREATE TABLE `ppr_research_experience` (
  `id` int(11) NOT NULL,
  `details` text NOT NULL,
  `owner_id` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_research_impact_pathway`
--

CREATE TABLE `ppr_research_impact_pathway` (
  `id` int(255) NOT NULL,
  `resultsID` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `ResearchOutputs1` text NOT NULL,
  `ResearchOutputsIndicators1` text NOT NULL,
  `ResearchOutcomes1` text NOT NULL,
  `ResearchOutcomesIndicators1` text NOT NULL,
  `Impact1` text NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_review_concents`
--

CREATE TABLE `ppr_review_concents` (
  `id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `ProjectInformation` int(11) NOT NULL,
  `PrincipalInvestigator` int(11) NOT NULL,
  `Introduction` int(11) NOT NULL,
  `ProjectDetails` int(11) NOT NULL,
  `Budget` int(11) NOT NULL,
  `cReferences` int(11) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `reviewer_id` int(255) NOT NULL,
  `Attachments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_review_dynamic_concepts`
--

CREATE TABLE `ppr_review_dynamic_concepts` (
  `id` int(255) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `grantID` int(255) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `dconceptID` int(255) NOT NULL,
  `reviewer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_review_dynamic_concepts`
--

INSERT INTO `ppr_review_dynamic_concepts` (`id`, `categoryID`, `owner_id`, `status`, `grantID`, `is_sent`, `dconceptID`, `reviewer_id`) VALUES
(1, 1, 287, 'new', 1, 0, 1, 112),
(2, 2, 287, 'new', 1, 0, 1, 112),
(3, 3, 287, 'completed', 1, 1, 0, 112),
(4, 4, 287, 'completed', 1, 1, 0, 112),
(5, 5, 287, 'completed', 1, 1, 0, 112),
(6, 6, 287, 'completed', 1, 1, 0, 112),
(7, 7, 287, 'completed', 1, 1, 0, 112),
(8, 7, 287, 'new', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ppr_review_dynamic_proposals`
--

CREATE TABLE `ppr_review_dynamic_proposals` (
  `id` int(255) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `grantID` int(255) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 0,
  `dproposalID` int(255) NOT NULL,
  `reviewer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_review_proposals`
--

CREATE TABLE `ppr_review_proposals` (
  `id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `projectID` int(255) NOT NULL,
  `ProjectInformation` int(11) NOT NULL,
  `PrincipalInvestigator` int(11) NOT NULL,
  `Background` int(11) NOT NULL,
  `Methodology` int(11) NOT NULL,
  `ProjectResults` int(11) NOT NULL,
  `ProjectManagement` int(11) NOT NULL,
  `Followup` int(11) NOT NULL,
  `Budget` int(11) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  `status` enum('new','completed') NOT NULL DEFAULT 'new',
  `reviewer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_submissions_concepts`
--

CREATE TABLE `ppr_submissions_concepts` (
  `conceptID` int(255) NOT NULL,
  `projectTitle` varchar(255) DEFAULT NULL,
  `titleAcronym` varchar(10) DEFAULT NULL,
  `relevantKeywords` text DEFAULT NULL,
  `researchTypeID` int(11) DEFAULT NULL,
  `projectDurationID` int(11) DEFAULT NULL,
  `updatedon` datetime DEFAULT NULL,
  `owner_id` int(255) DEFAULT NULL,
  `projectCategory` varchar(20) DEFAULT NULL,
  `projectStatus` enum('Pending Final Submission','Pending Review','Approved','Rejected','Scheduled for Review','Reviewed') DEFAULT 'Pending Final Submission',
  `is_sent` int(11) DEFAULT NULL,
  `HostInstitution` varchar(255) NOT NULL,
  `rejectComents` text NOT NULL,
  `finalSubmission` enum('Made Final Submission','Pending Final Submission') NOT NULL DEFAULT 'Pending Final Submission',
  `grantcallID` int(100) NOT NULL,
  `referenceNo` varchar(255) NOT NULL,
  `conceptm_Times` int(11) NOT NULL,
  `conceptm_Reviewers` int(11) NOT NULL,
  `category` enum('proposal','concepts') NOT NULL DEFAULT 'concepts',
  `invited_for_proposal` enum('notinvited','invited') NOT NULL DEFAULT 'notinvited',
  `projectYears` int(11) NOT NULL,
  `creferences` text NOT NULL,
  `updated` enum('no','yes') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_submissions_proposals`
--

CREATE TABLE `ppr_submissions_proposals` (
  `projectID` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `projectTitle` varchar(255) DEFAULT NULL,
  `titleAcronym` varchar(10) DEFAULT NULL,
  `relevantKeywords` text DEFAULT NULL,
  `researchTypeID` int(11) DEFAULT NULL,
  `projectDurationID` int(11) DEFAULT NULL,
  `updatedon` datetime DEFAULT NULL,
  `owner_id` int(255) DEFAULT NULL,
  `projectCategory` varchar(20) DEFAULT NULL,
  `projectStatus` enum('Pending Final Submission','Pending Review','Approved','Rejected','Scheduled for Review','Reviewed') DEFAULT 'Pending Final Submission',
  `is_sent` int(11) DEFAULT NULL,
  `HostInstitution` varchar(255) NOT NULL,
  `rejectComents` text NOT NULL,
  `finalSubmission` enum('Made Final Submission','Pending Final Submission') NOT NULL DEFAULT 'Pending Final Submission',
  `PrincipalInvestigator` varchar(255) NOT NULL,
  `Totalfunding` varchar(100) NOT NULL,
  `conceptm_Times` int(11) NOT NULL,
  `conceptm_Reviewers` int(11) NOT NULL,
  `category` enum('proposal','concepts') NOT NULL DEFAULT 'proposal',
  `projectYears` varchar(50) NOT NULL,
  `grantcallID` int(150) NOT NULL,
  `creferences` text NOT NULL,
  `referenceNo` varchar(255) NOT NULL,
  `awarded` enum('No','Yes') NOT NULL DEFAULT 'No',
  `BeginProject` varchar(50) NOT NULL,
  `EndProject` varchar(50) NOT NULL,
  `AmountofGrantawarded` varchar(100) NOT NULL,
  `DurationofGrant` varchar(100) NOT NULL,
  `TermsConditions` enum('No','Yes') NOT NULL DEFAULT 'No',
  `currency` varchar(20) NOT NULL,
  `GrantBalance` varchar(255) NOT NULL,
  `haltstudy` enum('No','Yes') NOT NULL DEFAULT 'No',
  `haltreason` text NOT NULL,
  `appeals` enum('No','Yes') NOT NULL DEFAULT 'No',
  `appealHalting` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_team_members`
--

CREATE TABLE `ppr_team_members` (
  `piID` int(255) NOT NULL,
  `conceptm_id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `Surname` varchar(255) DEFAULT NULL,
  `Othername` varchar(150) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `AgeRange` varchar(100) DEFAULT NULL,
  `Contacts` varchar(150) DEFAULT NULL,
  `Expertise` varchar(255) DEFAULT NULL,
  `EducationalBackground` varchar(255) DEFAULT NULL,
  `Qualifications` varchar(255) DEFAULT NULL,
  `ResearchExperience` varchar(255) DEFAULT NULL,
  `RoleofTeamMember` varchar(2) DEFAULT NULL,
  `InstitutionofAffiliation` varchar(255) NOT NULL,
  `updatedon` datetime NOT NULL,
  `is_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ppr_work_experience`
--

CREATE TABLE `ppr_work_experience` (
  `id` int(255) NOT NULL,
  `rstug_user_id` int(255) NOT NULL,
  `conceptID` int(255) NOT NULL,
  `Institution` varchar(255) NOT NULL,
  `PositionHeld` varchar(255) NOT NULL,
  `YearofRecruitment` varchar(50) NOT NULL,
  `YearofDeparture` varchar(50) NOT NULL,
  `dateAdded` varchar(50) NOT NULL,
  `is_sent` int(11) NOT NULL,
  `piID` int(255) NOT NULL,
  `catNormal` enum('static','dynamic') NOT NULL DEFAULT 'static'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_work_experience`
--

INSERT INTO `ppr_work_experience` (`id`, `rstug_user_id`, `conceptID`, `Institution`, `PositionHeld`, `YearofRecruitment`, `YearofDeparture`, `dateAdded`, `is_sent`, `piID`, `catNormal`) VALUES
(1, 287, 0, 'Catholic Medical School', 'Manager', '2018', '2021', '2021-06-17 14:58:32', 0, 0, 'dynamic'),
(2, 287, 0, 'mmdmdmfmgfg', 'wyeyreyryeyr', '2019', '2021', '2021-06-17 15:37:59', 0, 0, 'dynamic'),
(3, 287, 0, 'Kampoala Covid', 'Manager GFams', '2011', '2019', '2021-06-17 15:48:22', 0, 0, 'dynamic');

-- --------------------------------------------------------

--
-- Table structure for table `ppr_yearsm`
--

CREATE TABLE `ppr_yearsm` (
  `yearID` int(11) NOT NULL,
  `yearm` varchar(10) NOT NULL,
  `yeardesc` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppr_yearsm`
--

INSERT INTO `ppr_yearsm` (`yearID`, `yearm`, `yeardesc`) VALUES
(1, '1', 'Year'),
(2, '2', 'Years'),
(3, '3', 'Years'),
(4, '4', 'Years'),
(5, '5', 'Years');

-- --------------------------------------------------------

--
-- Table structure for table `scth_countries`
--

CREATE TABLE `scth_countries` (
  `country_id` int(11) NOT NULL,
  `countryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scth_countries`
--

INSERT INTO `scth_countries` (`country_id`, `countryName`) VALUES
(1, 'Afghanistan'),
(2, 'Albanian'),
(3, 'Algeria'),
(4, 'Andorra'),
(5, 'Anguila'),
(6, 'Antarctica'),
(7, 'Antigua and Barbuda'),
(8, 'Argentina'),
(9, 'Armenia'),
(10, 'Aruba'),
(11, 'Australia'),
(12, 'Austria'),
(13, 'Azerbaidjan'),
(14, 'Bahamas'),
(15, 'Bahrain'),
(16, 'Bangladesh'),
(17, 'Barbados'),
(18, 'Belarus'),
(19, 'Belgium'),
(20, 'Belize'),
(21, 'Bermuda'),
(22, 'Bhutan'),
(23, 'Bolivia'),
(24, 'Bosnia and Herzegovina'),
(25, 'Brazil'),
(26, 'Brunei'),
(27, 'Bulgaria'),
(28, 'Burundi'),
(29, 'Cambodia'),
(30, 'Canada'),
(31, 'Cape Verde'),
(32, 'Cayman Islands'),
(33, 'Chile'),
(34, 'China'),
(35, 'Christmans Islands'),
(36, 'Cocos Island'),
(37, 'Colombia'),
(38, 'Cook Islands'),
(39, 'Costa Rica'),
(40, 'Croatia'),
(41, 'Cuba'),
(42, 'Cyprus'),
(43, 'Czech Republic'),
(44, 'Denmark'),
(45, 'Dominica'),
(46, 'Dominican Republic'),
(47, 'Democratic Republic of Congo'),
(48, 'Ecuador'),
(49, 'Egypt'),
(50, 'El Salvador'),
(51, 'Estonia'),
(52, 'Ethiopia'),
(53, 'Falkland Islands'),
(54, 'Faroe Islands'),
(55, 'Fiji'),
(56, 'Finland'),
(57, 'France'),
(58, 'French Guyana'),
(59, 'French Polynesia'),
(60, 'Gabon'),
(61, 'Ghana'),
(62, 'Germany'),
(63, 'Gibraltar'),
(64, 'Georgia'),
(65, 'Greece'),
(66, 'Greenland'),
(67, 'Grenada'),
(68, 'Guadeloupe'),
(69, 'Guatemala'),
(70, 'Guinea-Bissau'),
(71, 'Guinea'),
(72, 'Haiti'),
(73, 'Honduras'),
(74, 'Hong Kong'),
(75, 'Hungary'),
(76, 'Iceland'),
(77, 'India'),
(78, 'Indonesia'),
(79, 'Ireland'),
(80, 'Israel'),
(81, 'Italy'),
(82, 'Jamaica'),
(83, 'Japan'),
(84, 'Jordan'),
(85, 'Kazakhstan'),
(86, 'Kenya'),
(87, 'Kiribati'),
(88, 'Kuwait'),
(89, 'Kyrgyzstan'),
(90, 'Lao People\'s Democratic Republic'),
(91, 'Latvia'),
(92, 'Lebanon'),
(93, 'Liechtenstein'),
(94, 'Lithuania'),
(95, 'Luxembourg'),
(96, 'Macedonia'),
(97, 'Madagascar'),
(98, 'Malawi'),
(99, 'Malaysia'),
(100, 'Maldives'),
(101, 'Mali'),
(102, 'Malta'),
(103, 'Marocco'),
(104, 'Marshall Islands'),
(105, 'Mauritania'),
(106, 'Mauritius'),
(107, 'Mexico'),
(108, 'Micronesia'),
(109, 'Moldavia'),
(110, 'Monaco'),
(111, 'Mongolia'),
(112, 'Myanmar'),
(113, 'Nauru'),
(114, 'Nepal'),
(115, 'Netherlands Antilles'),
(116, 'Netherlands'),
(117, 'New Zealand'),
(118, 'Nigeria'),
(119, 'Niue'),
(120, 'North Korea'),
(121, 'Norway'),
(122, 'Oman'),
(123, 'Pakistan'),
(124, 'Palau'),
(125, 'Panama'),
(126, 'Papua New Guinea'),
(127, 'Paraguay'),
(128, 'Peru'),
(129, 'Philippines'),
(130, 'Poland'),
(131, 'Portugal'),
(132, 'Puerto Rico'),
(133, 'Qatar'),
(134, 'Republic of Korea Reunion'),
(135, 'Romania'),
(136, 'Russia'),
(137, 'Rwanda'),
(138, 'Saint Helena'),
(139, 'Saint kitts and nevis'),
(140, 'Saint Lucia'),
(141, 'Samoa'),
(142, 'San Marino'),
(143, 'Saudi Arabia'),
(144, 'Seychelles'),
(145, 'Singapore'),
(146, 'Slovakia'),
(147, 'Slovenia'),
(148, 'Solomon Islands'),
(149, 'South Africa'),
(150, 'Somalia'),
(151, 'Spain'),
(152, 'Sri Lanka'),
(153, 'St.Pierre and Miquelon'),
(154, 'St.Vincent and the Grenadines'),
(155, 'Sudan'),
(156, 'South Sudan'),
(157, 'Sweden'),
(158, 'Switzerland'),
(159, 'Syria'),
(160, 'Taiwan'),
(161, 'Tajikistan'),
(162, 'Tanzania'),
(163, 'Thailand'),
(164, 'Trinidad and Tobago'),
(165, 'Turkey'),
(166, 'Turkmenistan'),
(167, 'Turks and Caicos Islands'),
(168, 'Ukraine'),
(169, 'UAE'),
(170, 'Uganda'),
(171, 'UK'),
(172, 'USA'),
(173, 'Uruguay'),
(174, 'Uzbekistan'),
(175, 'Vanuatu'),
(176, 'Vatican City'),
(177, 'Vietnam'),
(178, 'Virgin Islands (GB)'),
(179, 'Virgin Islands (U.S.)'),
(180, 'Wallis and Futuna Islands'),
(181, 'Yemen'),
(182, 'Yugoslavia'),
(183, 'Zambia'),
(184, 'Zimbabwe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ppr_appeal_halted_studies`
--
ALTER TABLE `ppr_appeal_halted_studies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_categories`
--
ALTER TABLE `ppr_categories`
  ADD PRIMARY KEY (`rstug_categoryID`);

--
-- Indexes for table `ppr_concepts`
--
ALTER TABLE `ppr_concepts`
  ADD PRIMARY KEY (`conceptm_id`);

--
-- Indexes for table `ppr_conceptsasslogs`
--
ALTER TABLE `ppr_conceptsasslogs`
  ADD PRIMARY KEY (`assignm_id`);

--
-- Indexes for table `ppr_conceptsasslogs_new`
--
ALTER TABLE `ppr_conceptsasslogs_new`
  ADD PRIMARY KEY (`assignm_id`);

--
-- Indexes for table `ppr_concepts_cvs`
--
ALTER TABLE `ppr_concepts_cvs`
  ADD PRIMARY KEY (`cvID`);

--
-- Indexes for table `ppr_concepts_dates`
--
ALTER TABLE `ppr_concepts_dates`
  ADD PRIMARY KEY (`dateID`);

--
-- Indexes for table `ppr_concept_attachments`
--
ALTER TABLE `ppr_concept_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_concept_budget`
--
ALTER TABLE `ppr_concept_budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_concept_references`
--
ALTER TABLE `ppr_concept_references`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_concept_stages`
--
ALTER TABLE `ppr_concept_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_countries`
--
ALTER TABLE `ppr_countries`
  ADD PRIMARY KEY (`cidm_country_id`);

--
-- Indexes for table `ppr_currency`
--
ALTER TABLE `ppr_currency`
  ADD PRIMARY KEY (`currencyID`);

--
-- Indexes for table `ppr_duration`
--
ALTER TABLE `ppr_duration`
  ADD PRIMARY KEY (`durationID`);

--
-- Indexes for table `ppr_dynamic_budget_answers`
--
ALTER TABLE `ppr_dynamic_budget_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_dynamic_categories_main`
--
ALTER TABLE `ppr_dynamic_categories_main`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ppr_dynamic_concept_stages`
--
ALTER TABLE `ppr_dynamic_concept_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_dynamic_concept_titles`
--
ALTER TABLE `ppr_dynamic_concept_titles`
  ADD PRIMARY KEY (`dconceptID`);

--
-- Indexes for table `ppr_dynamic_proposal_stages`
--
ALTER TABLE `ppr_dynamic_proposal_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_dynamic_proposal_titles`
--
ALTER TABLE `ppr_dynamic_proposal_titles`
  ADD PRIMARY KEY (`dproposalID`);

--
-- Indexes for table `ppr_education_history`
--
ALTER TABLE `ppr_education_history`
  ADD PRIMARY KEY (`rstug_educn_id`);

--
-- Indexes for table `ppr_grantcalls`
--
ALTER TABLE `ppr_grantcalls`
  ADD PRIMARY KEY (`grantID`);

--
-- Indexes for table `ppr_grantcall_categories`
--
ALTER TABLE `ppr_grantcall_categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `ppr_grantcall_qn_answers_concept`
--
ALTER TABLE `ppr_grantcall_qn_answers_concept`
  ADD PRIMARY KEY (`answerID`);

--
-- Indexes for table `ppr_grantcall_qn_answers_proposal`
--
ALTER TABLE `ppr_grantcall_qn_answers_proposal`
  ADD PRIMARY KEY (`answerID`);

--
-- Indexes for table `ppr_grantcall_questions`
--
ALTER TABLE `ppr_grantcall_questions`
  ADD PRIMARY KEY (`questionID`);

--
-- Indexes for table `ppr_grantcall_questions_attachments`
--
ALTER TABLE `ppr_grantcall_questions_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_grantcall_questions_budget`
--
ALTER TABLE `ppr_grantcall_questions_budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_grantcall_questions_checkboxes`
--
ALTER TABLE `ppr_grantcall_questions_checkboxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_grantcall_questions_dropdown`
--
ALTER TABLE `ppr_grantcall_questions_dropdown`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_grantcall_questions_radiobutton`
--
ALTER TABLE `ppr_grantcall_questions_radiobutton`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_grants_funds`
--
ALTER TABLE `ppr_grants_funds`
  ADD PRIMARY KEY (`fundsID`);

--
-- Indexes for table `ppr_introduction_concept`
--
ALTER TABLE `ppr_introduction_concept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_mlogs`
--
ALTER TABLE `ppr_mlogs`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `ppr_monitoring_reports`
--
ALTER TABLE `ppr_monitoring_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_mscores`
--
ALTER TABLE `ppr_mscores`
  ADD PRIMARY KEY (`scoredmID`);

--
-- Indexes for table `ppr_mscores_new`
--
ALTER TABLE `ppr_mscores_new`
  ADD PRIMARY KEY (`scoredmID`);

--
-- Indexes for table `ppr_musers`
--
ALTER TABLE `ppr_musers`
  ADD PRIMARY KEY (`usrm_id`),
  ADD UNIQUE KEY `username` (`usrm_username`);

--
-- Indexes for table `ppr_pages`
--
ALTER TABLE `ppr_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_possible_risk`
--
ALTER TABLE `ppr_possible_risk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_potential_for_synergy`
--
ALTER TABLE `ppr_potential_for_synergy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_principal_investigators`
--
ALTER TABLE `ppr_principal_investigators`
  ADD PRIMARY KEY (`piID`);

--
-- Indexes for table `ppr_progress_meeting_abstracts`
--
ALTER TABLE `ppr_progress_meeting_abstracts`
  ADD PRIMARY KEY (`meetingAbstractID`);

--
-- Indexes for table `ppr_progress_report_keypersonnel_effort`
--
ALTER TABLE `ppr_progress_report_keypersonnel_effort`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_progress_report_otherpresentations`
--
ALTER TABLE `ppr_progress_report_otherpresentations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_progress_report_review`
--
ALTER TABLE `ppr_progress_report_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_progress_report_signature_page`
--
ALTER TABLE `ppr_progress_report_signature_page`
  ADD PRIMARY KEY (`progressID`);

--
-- Indexes for table `ppr_progress_report_stages`
--
ALTER TABLE `ppr_progress_report_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_progress_report_summary_progress`
--
ALTER TABLE `ppr_progress_report_summary_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_projects_objectives`
--
ALTER TABLE `ppr_projects_objectives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_background`
--
ALTER TABLE `ppr_project_background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_budget`
--
ALTER TABLE `ppr_project_budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_details_concept`
--
ALTER TABLE `ppr_project_details_concept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_follow_up`
--
ALTER TABLE `ppr_project_follow_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_management`
--
ALTER TABLE `ppr_project_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_methodology`
--
ALTER TABLE `ppr_project_methodology`
  ADD PRIMARY KEY (`methodologyID`);

--
-- Indexes for table `ppr_project_methodology_donors`
--
ALTER TABLE `ppr_project_methodology_donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_primary_beneficiaries`
--
ALTER TABLE `ppr_project_primary_beneficiaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_results`
--
ALTER TABLE `ppr_project_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_project_stages`
--
ALTER TABLE `ppr_project_stages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_proposal_research_team`
--
ALTER TABLE `ppr_proposal_research_team`
  ADD PRIMARY KEY (`piID`);

--
-- Indexes for table `ppr_proposal_research_team_ext`
--
ALTER TABLE `ppr_proposal_research_team_ext`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_request_for_funds`
--
ALTER TABLE `ppr_request_for_funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_request_for_funds_main`
--
ALTER TABLE `ppr_request_for_funds_main`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_request_for_procurement`
--
ALTER TABLE `ppr_request_for_procurement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_research_experience`
--
ALTER TABLE `ppr_research_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_research_impact_pathway`
--
ALTER TABLE `ppr_research_impact_pathway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_review_concents`
--
ALTER TABLE `ppr_review_concents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_review_dynamic_concepts`
--
ALTER TABLE `ppr_review_dynamic_concepts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_review_dynamic_proposals`
--
ALTER TABLE `ppr_review_dynamic_proposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_review_proposals`
--
ALTER TABLE `ppr_review_proposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_submissions_concepts`
--
ALTER TABLE `ppr_submissions_concepts`
  ADD PRIMARY KEY (`conceptID`);

--
-- Indexes for table `ppr_submissions_proposals`
--
ALTER TABLE `ppr_submissions_proposals`
  ADD PRIMARY KEY (`projectID`);

--
-- Indexes for table `ppr_team_members`
--
ALTER TABLE `ppr_team_members`
  ADD PRIMARY KEY (`piID`);

--
-- Indexes for table `ppr_work_experience`
--
ALTER TABLE `ppr_work_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppr_yearsm`
--
ALTER TABLE `ppr_yearsm`
  ADD PRIMARY KEY (`yearID`);

--
-- Indexes for table `scth_countries`
--
ALTER TABLE `scth_countries`
  ADD PRIMARY KEY (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ppr_appeal_halted_studies`
--
ALTER TABLE `ppr_appeal_halted_studies`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_categories`
--
ALTER TABLE `ppr_categories`
  MODIFY `rstug_categoryID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ppr_concepts`
--
ALTER TABLE `ppr_concepts`
  MODIFY `conceptm_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_conceptsasslogs`
--
ALTER TABLE `ppr_conceptsasslogs`
  MODIFY `assignm_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_conceptsasslogs_new`
--
ALTER TABLE `ppr_conceptsasslogs_new`
  MODIFY `assignm_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppr_concepts_cvs`
--
ALTER TABLE `ppr_concepts_cvs`
  MODIFY `cvID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_concepts_dates`
--
ALTER TABLE `ppr_concepts_dates`
  MODIFY `dateID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_concept_attachments`
--
ALTER TABLE `ppr_concept_attachments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ppr_concept_budget`
--
ALTER TABLE `ppr_concept_budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_concept_references`
--
ALTER TABLE `ppr_concept_references`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_concept_stages`
--
ALTER TABLE `ppr_concept_stages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_currency`
--
ALTER TABLE `ppr_currency`
  MODIFY `currencyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ppr_duration`
--
ALTER TABLE `ppr_duration`
  MODIFY `durationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `ppr_dynamic_budget_answers`
--
ALTER TABLE `ppr_dynamic_budget_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ppr_dynamic_categories_main`
--
ALTER TABLE `ppr_dynamic_categories_main`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ppr_dynamic_concept_stages`
--
ALTER TABLE `ppr_dynamic_concept_stages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ppr_dynamic_concept_titles`
--
ALTER TABLE `ppr_dynamic_concept_titles`
  MODIFY `dconceptID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ppr_dynamic_proposal_stages`
--
ALTER TABLE `ppr_dynamic_proposal_stages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_dynamic_proposal_titles`
--
ALTER TABLE `ppr_dynamic_proposal_titles`
  MODIFY `dproposalID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_education_history`
--
ALTER TABLE `ppr_education_history`
  MODIFY `rstug_educn_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppr_grantcalls`
--
ALTER TABLE `ppr_grantcalls`
  MODIFY `grantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ppr_grantcall_categories`
--
ALTER TABLE `ppr_grantcall_categories`
  MODIFY `categoryID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ppr_grantcall_qn_answers_concept`
--
ALTER TABLE `ppr_grantcall_qn_answers_concept`
  MODIFY `answerID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ppr_grantcall_qn_answers_proposal`
--
ALTER TABLE `ppr_grantcall_qn_answers_proposal`
  MODIFY `answerID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_grantcall_questions`
--
ALTER TABLE `ppr_grantcall_questions`
  MODIFY `questionID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ppr_grantcall_questions_attachments`
--
ALTER TABLE `ppr_grantcall_questions_attachments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ppr_grantcall_questions_budget`
--
ALTER TABLE `ppr_grantcall_questions_budget`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ppr_grantcall_questions_checkboxes`
--
ALTER TABLE `ppr_grantcall_questions_checkboxes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_grantcall_questions_dropdown`
--
ALTER TABLE `ppr_grantcall_questions_dropdown`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_grantcall_questions_radiobutton`
--
ALTER TABLE `ppr_grantcall_questions_radiobutton`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_grants_funds`
--
ALTER TABLE `ppr_grants_funds`
  MODIFY `fundsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_introduction_concept`
--
ALTER TABLE `ppr_introduction_concept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_mlogs`
--
ALTER TABLE `ppr_mlogs`
  MODIFY `lid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppr_monitoring_reports`
--
ALTER TABLE `ppr_monitoring_reports`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_mscores`
--
ALTER TABLE `ppr_mscores`
  MODIFY `scoredmID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_mscores_new`
--
ALTER TABLE `ppr_mscores_new`
  MODIFY `scoredmID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_musers`
--
ALTER TABLE `ppr_musers`
  MODIFY `usrm_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT for table `ppr_pages`
--
ALTER TABLE `ppr_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_possible_risk`
--
ALTER TABLE `ppr_possible_risk`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_potential_for_synergy`
--
ALTER TABLE `ppr_potential_for_synergy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_principal_investigators`
--
ALTER TABLE `ppr_principal_investigators`
  MODIFY `piID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppr_progress_meeting_abstracts`
--
ALTER TABLE `ppr_progress_meeting_abstracts`
  MODIFY `meetingAbstractID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_progress_report_keypersonnel_effort`
--
ALTER TABLE `ppr_progress_report_keypersonnel_effort`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_progress_report_otherpresentations`
--
ALTER TABLE `ppr_progress_report_otherpresentations`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_progress_report_review`
--
ALTER TABLE `ppr_progress_report_review`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_progress_report_signature_page`
--
ALTER TABLE `ppr_progress_report_signature_page`
  MODIFY `progressID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_progress_report_stages`
--
ALTER TABLE `ppr_progress_report_stages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_progress_report_summary_progress`
--
ALTER TABLE `ppr_progress_report_summary_progress`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_projects_objectives`
--
ALTER TABLE `ppr_projects_objectives`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_background`
--
ALTER TABLE `ppr_project_background`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_budget`
--
ALTER TABLE `ppr_project_budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_details_concept`
--
ALTER TABLE `ppr_project_details_concept`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_follow_up`
--
ALTER TABLE `ppr_project_follow_up`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_management`
--
ALTER TABLE `ppr_project_management`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_methodology`
--
ALTER TABLE `ppr_project_methodology`
  MODIFY `methodologyID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_methodology_donors`
--
ALTER TABLE `ppr_project_methodology_donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_primary_beneficiaries`
--
ALTER TABLE `ppr_project_primary_beneficiaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_results`
--
ALTER TABLE `ppr_project_results`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_project_stages`
--
ALTER TABLE `ppr_project_stages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_proposal_research_team`
--
ALTER TABLE `ppr_proposal_research_team`
  MODIFY `piID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_proposal_research_team_ext`
--
ALTER TABLE `ppr_proposal_research_team_ext`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_request_for_funds`
--
ALTER TABLE `ppr_request_for_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_request_for_funds_main`
--
ALTER TABLE `ppr_request_for_funds_main`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_request_for_procurement`
--
ALTER TABLE `ppr_request_for_procurement`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_research_experience`
--
ALTER TABLE `ppr_research_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_research_impact_pathway`
--
ALTER TABLE `ppr_research_impact_pathway`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_review_concents`
--
ALTER TABLE `ppr_review_concents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_review_dynamic_concepts`
--
ALTER TABLE `ppr_review_dynamic_concepts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ppr_review_dynamic_proposals`
--
ALTER TABLE `ppr_review_dynamic_proposals`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_review_proposals`
--
ALTER TABLE `ppr_review_proposals`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_submissions_concepts`
--
ALTER TABLE `ppr_submissions_concepts`
  MODIFY `conceptID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_submissions_proposals`
--
ALTER TABLE `ppr_submissions_proposals`
  MODIFY `projectID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_team_members`
--
ALTER TABLE `ppr_team_members`
  MODIFY `piID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppr_work_experience`
--
ALTER TABLE `ppr_work_experience`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppr_yearsm`
--
ALTER TABLE `ppr_yearsm`
  MODIFY `yearID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scth_countries`
--
ALTER TABLE `scth_countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
