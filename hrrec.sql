-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2021 at 06:16 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrrec`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `AId` int(11) NOT NULL,
  `AttemptId` int(11) NOT NULL,
  `QId` int(11) NOT NULL,
  `AnswerGiven` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointing`
--

CREATE TABLE `appointing` (
  `AppointId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `A_Date` date NOT NULL,
  `AppLetter` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campus_costing`
--

CREATE TABLE `campus_costing` (
  `id` int(11) NOT NULL,
  `JPId` int(11) NOT NULL,
  `university` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fromdt` date NOT NULL,
  `todt` date NOT NULL,
  `appeared` int(11) NOT NULL,
  `hired` int(11) NOT NULL,
  `avg_cost` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RT1` int(11) NOT NULL DEFAULT 0,
  `RT2` int(11) NOT NULL DEFAULT 0,
  `RT3` int(11) NOT NULL DEFAULT 0,
  `RT4` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidateeducation`
--

CREATE TABLE `candidateeducation` (
  `CEId` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `Qualification` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Course` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Specialization` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Institute` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `YearOfPassing` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CGPA` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `LastUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_ctc`
--

CREATE TABLE `candidate_ctc` (
  `CTCId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `ctcLetterNo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctc_date` date NOT NULL,
  `basic` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hra` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bonus` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `special_alw` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grsM_salary` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emplyPF` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emplyESIC` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `netMonth` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lta` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `childedu` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anualgrs` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gratuity` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emplyerPF` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emplyerESIC` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medical` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_ctc` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_entitlement`
--

CREATE TABLE `candidate_entitlement` (
  `ENTId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `EntLetterNo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EntDate` date NOT NULL,
  `LoadCityA` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LoadCityB` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LoadCityC` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DAOut` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DAHq` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TwoWheel` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FourWheel` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TravelMode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TravelClass` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mobile` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MExpense` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MTerm` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GPRS` tinyint(4) NOT NULL DEFAULT 0,
  `Laptop` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HealthIns` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TravelLine` tinyint(4) NOT NULL DEFAULT 0,
  `Created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `Created_by` int(11) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_ref`
--

CREATE TABLE `candidate_ref` (
  `REFId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `Company` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `Designation` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReportMgr` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmpType` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Agency` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NetMonth` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CTC` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AbilityTeam` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Loyal` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Leadership` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Relationship` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CharacterConduct` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Strength` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Weakness` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `LeaveReason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Rehire` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `AnyOther` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `VerifierName` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `VDesig` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contact` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candjoining`
--

CREATE TABLE `candjoining` (
  `CJId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `LinkValidityStart` date NOT NULL,
  `LinkValidityEnd` date NOT NULL,
  `LinkStatus` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JoinOnDt` date NOT NULL,
  `FailingWhi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Signature` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Answer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RejReason` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Aadhar` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PanCard` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BankDoc` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefCheck` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `PositionCode` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmpCode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Verification` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Verified',
  `ForwardToESS` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examattempt`
--

CREATE TABLE `examattempt` (
  `AttemptId` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `ExamId` int(11) NOT NULL,
  `LEEId` int(11) NOT NULL,
  `ExamStart` datetime NOT NULL,
  `ExamEnd` datetime NOT NULL,
  `TimePassed` time NOT NULL,
  `Answers` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SAnswer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Score` int(11) NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ExamOverReason` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AnsChecked` tinyint(4) NOT NULL DEFAULT 0,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examroom`
--

CREATE TABLE `examroom` (
  `RoomId` int(11) NOT NULL,
  `RoomName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsDelete` tinyint(4) NOT NULL DEFAULT 0,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firob`
--

CREATE TABLE `firob` (
  `FirobId` int(11) NOT NULL,
  `FiroE` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FiroH` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FiroO` int(11) NOT NULL,
  `FiroF` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FiroSts` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `ns1` int(11) NOT NULL,
  `ns2` int(11) NOT NULL,
  `ns3` int(11) NOT NULL,
  `ns4` int(11) NOT NULL,
  `ns5` int(11) NOT NULL,
  `FiroCre` int(11) NOT NULL,
  `FiroCreDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firob_object`
--

CREATE TABLE `firob_object` (
  `FirobOId` int(11) NOT NULL,
  `FiroF` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `e1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `h2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `e2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `h3` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `e3` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `h4` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `e4` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `h5` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `e5` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `h6` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `e6` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firob_qset`
--

CREATE TABLE `firob_qset` (
  `FirobQSetId` int(11) NOT NULL,
  `FiroSetN` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q1` int(11) NOT NULL,
  `q2` int(11) NOT NULL,
  `q3` int(11) NOT NULL,
  `q4` int(11) NOT NULL,
  `q5` int(11) NOT NULL,
  `q6` int(11) NOT NULL,
  `q7` int(11) NOT NULL,
  `q8` int(11) NOT NULL,
  `q9` int(11) NOT NULL,
  `q10` int(11) NOT NULL,
  `q1a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q2a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q3a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q4a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q5a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q6a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q7a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q8a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q9a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q10a` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firob_user`
--

CREATE TABLE `firob_user` (
  `FirobUId` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `FirobId` int(11) NOT NULL,
  `FirobUVal` int(11) NOT NULL DEFAULT 0,
  `SubSts` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'N-No, Y-Yse',
  `SubDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_employee_reporting`
--

CREATE TABLE `hrm_employee_reporting` (
  `ReportingId` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `AppraiserId` int(11) NOT NULL,
  `ReviewerId` int(11) NOT NULL,
  `HodId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intervcost`
--

CREATE TABLE `intervcost` (
  `ICId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `Travel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lodging` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Relocation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Other` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_about_ans`
--

CREATE TABLE `jf_about_ans` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `aqid` int(11) NOT NULL,
  `answer` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_about_questionare`
--

CREATE TABLE `jf_about_questionare` (
  `aqid` int(11) NOT NULL,
  `question` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_contact_det`
--

CREATE TABLE `jf_contact_det` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `perm_address` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perm_state` int(11) NOT NULL,
  `perm_dist` int(11) NOT NULL,
  `perm_city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perm_pin` int(11) NOT NULL,
  `pre_address` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pre_state` int(11) NOT NULL,
  `pre_dist` int(11) NOT NULL,
  `pre_city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pre_pin` int(11) NOT NULL,
  `cont_one_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cont_one_relation` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cont_one_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cont_two_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cont_two_relation` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cont_two_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_docs`
--

CREATE TABLE `jf_docs` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `Aadhar` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PanCard` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BankDoc` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PF_Form2` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PF_Form11` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gratutity` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ESIC` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ESIC_Family` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Health` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Ethical` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DL` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BloodGroup` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_docs_more`
--

CREATE TABLE `jf_docs_more` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `document_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_family_det`
--

CREATE TABLE `jf_family_det` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `relation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `qualification` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_language`
--

CREATE TABLE `jf_language` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `language` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` int(11) NOT NULL DEFAULT 0,
  `write` int(11) NOT NULL DEFAULT 0,
  `speak` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_pf_esic`
--

CREATE TABLE `jf_pf_esic` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `prof_fresher` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UAN` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pf_acc_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `esic_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_reference`
--

CREATE TABLE `jf_reference` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `from` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rel_with_person` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_tranprac`
--

CREATE TABLE `jf_tranprac` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `training` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jf_work_exp`
--

CREATE TABLE `jf_work_exp` (
  `id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `company` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desgination` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_start` date NOT NULL,
  `job_end` date NOT NULL,
  `still_emp` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_mon_sal` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annual_ctc` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason_fr_leaving` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobapply`
--

CREATE TABLE `jobapply` (
  `JAId` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `JPId` int(11) NOT NULL,
  `Type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ResumeSouId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `Message` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KeyPositionCriteria` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GroupDiscussion` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SelectedBy` int(11) NOT NULL,
  `InterviewedBy` int(11) NOT NULL,
  `AssessmentSheet` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobcandidates`
--

CREATE TABLE `jobcandidates` (
  `JCId` int(11) NOT NULL,
  `RollNo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NameTitle` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DOB` date NOT NULL,
  `Gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_religion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Caste` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OtherCaste` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `State` int(11) NOT NULL,
  `Dist` int(11) NOT NULL,
  `City` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PinCode` int(11) NOT NULL,
  `MaritalStatus` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marriage_dt` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FatherName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Aadhar` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email1` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email2` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contact1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contact2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ProfessOrFresher` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `College` int(11) NOT NULL,
  `OtherCollege` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `WorkExpYears` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `WorkExpMonths` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CurCompany` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CurJobTitle` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CurDepartment` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CurDesignation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JobStartDate` date NOT NULL,
  `JobEndDate` date NOT NULL,
  `StillEmployed` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GMonthlySalary` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AnnualCTC` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OtherBenefits` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CurLocation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PrevInterviewed` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PrevInterviewedDate` date NOT NULL,
  `PrevInterviewedPosition` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CandidateImg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Resume` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefCompany` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefDesignatin` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefContact` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefEmail` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DrivingLicense` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LValidity` date NOT NULL,
  `Verified` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `EmailOTP` int(11) NOT NULL,
  `SMSOTP` int(11) NOT NULL,
  `PerM_Salary` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PreA_CTC` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DAHq` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DAOut` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PetrolAlw` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PhoneAlw` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HotelElg` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ExpCTC` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoticePeriod` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `InterviewSubmit` tinyint(4) NOT NULL DEFAULT 0,
  `FinalSubmit` tinyint(4) NOT NULL DEFAULT 0,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobpost`
--

CREATE TABLE `jobpost` (
  `JPId` int(11) NOT NULL,
  `MRFId` int(11) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `DesigId` int(11) NOT NULL,
  `JobCode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReqQualification` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `PayPackage` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `State` int(11) NOT NULL,
  `Location` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KeyPositionCriteria` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PostingView` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JobPostType` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastDate` date NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jsonpushchktbl`
--

CREATE TABLE `jsonpushchktbl` (
  `id` int(11) NOT NULL,
  `EmpCode` int(11) NOT NULL,
  `FName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keypostioncriteria`
--

CREATE TABLE `keypostioncriteria` (
  `KPCId` int(11) NOT NULL,
  `KeyPostionCriteria` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MRFId` int(11) NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `launchexam`
--

CREATE TABLE `launchexam` (
  `ExamId` int(11) NOT NULL,
  `RoomId` int(11) NOT NULL,
  `Status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `launchexam_exams`
--

CREATE TABLE `launchexam_exams` (
  `LEEId` int(11) NOT NULL,
  `ExamId` int(11) NOT NULL,
  `TestPaperId` int(11) NOT NULL,
  `TotalExamTime` int(11) NOT NULL,
  `NegativeMarking` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EnterNegativeMarks` int(11) NOT NULL,
  `EachQuestionTime` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EnterTime` int(11) NOT NULL,
  `ShuffleQuestion` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ShuffleAnswers` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `QuestionNavigation` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TimeRemainder` int(11) NOT NULL,
  `MaxWinSwitchAlerts` int(11) NOT NULL,
  `Instructions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Started',
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logbook`
--

CREATE TABLE `logbook` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logbook`
--

INSERT INTO `logbook` (`id`, `subject`, `url`, `method`, `ip`, `agent`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'New District Has been created', 'http://127.0.0.1:8000/admin/addDistrict', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36', 1, '2021-07-22 15:03:04', '2021-07-22 15:03:04'),
(2, 'New District Durg has been created', 'http://127.0.0.1:8000/admin/addDistrict', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36', 1, '2021-07-22 15:07:29', '2021-07-22 15:07:29'),
(3, 'New District Janjgir Champa has been created', 'http://127.0.0.1:8000/admin/addDistrict', 'POST', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36', 1, '2021-07-22 17:02:42', '2021-07-22 17:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manpowerrequisition`
--

CREATE TABLE `manpowerrequisition` (
  `MRFId` int(11) NOT NULL,
  `JobCode` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PositionCode` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RepEmployeeID` int(11) NOT NULL COMMENT 'EmployeeID',
  `Reason` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `DesigId` int(11) NOT NULL,
  `GradeId` int(11) NOT NULL,
  `Positions` int(11) NOT NULL,
  `LocationIds` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Reporting` int(11) NOT NULL,
  `ExistCTC` bigint(20) NOT NULL,
  `MinCTC` bigint(20) NOT NULL,
  `MaxCTC` bigint(20) NOT NULL,
  `WorkExp` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Remarks` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `EducationId` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EducationInsId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `KeyPositionCriteria` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KPC` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RemarkHr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Allocated` int(11) NOT NULL,
  `AllocatedDt` date NOT NULL,
  `CloseDt` date NOT NULL,
  `OnBehalf` int(11) NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_city`
--

CREATE TABLE `master_city` (
  `CityId` int(11) NOT NULL,
  `City` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_company`
--

CREATE TABLE `master_company` (
  `CompanyId` int(11) NOT NULL,
  `CompanyName` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CompanyCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Phone` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedTime` datetime DEFAULT current_timestamp(),
  `CreatedBy` int(11) DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_company`
--

INSERT INTO `master_company` (`CompanyId`, `CompanyName`, `CompanyCode`, `Address`, `Phone`, `Status`, `CreatedTime`, `CreatedBy`, `LastUpdated`, `UpdatedBy`) VALUES
(1, 'VNR Seeds Pvt. Ltd.', 'VSPL', 'Corporate Center Raipur', '7713200334', 'A', '2021-07-18 08:37:48', 1, '2021-07-18 10:01:56', 1),
(2, 'VNR Group Concern', 'VNR Group', 'Corporate Center Canal Road Crossing, Ring Road No. 01', '7713200334', 'A', '2021-07-18 08:37:48', 1, '2021-07-20 21:24:52', 1),
(3, 'VNR Nursery Pvt. Ltd.', 'VNPL', 'Corporate Center Canal Road Crossing, Ring Road No. 01', '7713200334', 'A', '2021-07-18 08:37:48', 1, '2021-07-20 21:25:19', 1),
(4, 'Teamlease Services Ltd.', 'Teamlease', 'BENGALURU', '8068243000', 'A', '2021-07-18 08:37:48', 1, '2021-07-18 08:38:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_country`
--

CREATE TABLE `master_country` (
  `CountryId` int(11) NOT NULL,
  `CountryName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CountryCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedTime` datetime NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_country`
--

INSERT INTO `master_country` (`CountryId`, `CountryName`, `CountryCode`, `Status`, `CreatedTime`, `CreatedBy`, `LastUpdated`, `UpdatedBy`, `IsDeleted`) VALUES
(1, 'INDIA', 'IND', 'A', '2021-07-18 08:57:55', 1, '2021-07-18 08:58:04', 1, 0),
(2, 'BANGLADESH', 'BNG', 'A', '2021-07-18 08:57:55', 1, '2021-07-18 08:58:10', 1, 0),
(3, 'SRILANKA', 'LKA', 'A', '2021-07-18 08:57:55', 1, '2021-07-18 08:58:17', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_department`
--

CREATE TABLE `master_department` (
  `DepartmentId` int(11) NOT NULL,
  `DepartmentName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DepartmentCode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Comment` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CompanyId` int(11) NOT NULL,
  `DeptStatus` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'A-active,D-deactive,De-delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_department`
--

INSERT INTO `master_department` (`DepartmentId`, `DepartmentName`, `DepartmentCode`, `Comment`, `CompanyId`, `DeptStatus`) VALUES
(1, 'Human Resource ', 'HR', NULL, 1, 'A'),
(2, 'Research & Development', 'R&D', NULL, 1, 'A'),
(3, 'Product Development ', 'PD', NULL, 1, 'A'),
(4, 'Production ', 'PRODUCTION', NULL, 1, 'A'),
(5, 'Processing', 'PROCESSING', NULL, 1, 'A'),
(6, 'Sales ', 'SALES', NULL, 1, 'A'),
(7, 'Logistics ', 'LOGISTICS', NULL, 1, 'A'),
(8, 'Finance ', 'FINANCE', NULL, 1, 'A'),
(9, 'Information Technology ', 'IT', NULL, 1, 'A'),
(10, 'Legal ', 'LEGAL', NULL, 1, 'A'),
(11, 'Admin', 'ADMIN', NULL, 1, 'A'),
(12, 'Marketing ', 'MARKETING', NULL, 1, 'A'),
(13, 'VNR FARMS PVT.LTD', 'VFPL', NULL, 2, 'A'),
(14, 'RAIPUR HOTICULTURAL FARM PVT. LTD.', 'RHFPL', NULL, 2, 'A'),
(15, 'HEMA SEEDS PVT. LTD. ', 'HSPL', NULL, 2, 'A'),
(16, 'DREAM AGRI RESEARCH PVT. LTD.', 'DARPL', NULL, 2, 'A'),
(17, 'Management ', 'MANAGEMENT', NULL, 1, 'A'),
(18, 'Management', 'MANAGEMENT', NULL, 2, 'A'),
(19, 'Sales', 'SALES', NULL, 3, 'A'),
(20, 'Account', 'ACCOUNT', NULL, 3, 'A'),
(21, 'Production', 'PRODUCTION', NULL, 3, 'A'),
(22, 'Customer Service', 'CS', NULL, 3, 'A'),
(23, 'Management', 'MANAGEMENT', NULL, 3, 'A'),
(24, 'Quality Assurance ', 'QA', NULL, 1, 'A'),
(25, 'Foundation Seed', 'FS', NULL, 1, 'A'),
(26, 'Admin', 'ADMIN', NULL, 3, 'A'),
(27, 'Seed Production Research ', 'SPR', NULL, 1, 'A'),
(28, 'Farm', 'FA', NULL, 1, 'A'),
(29, 'ADMIN', 'ADMIN', NULL, 4, 'A'),
(30, 'FINANCE', 'FINANCE', NULL, 4, 'A'),
(31, 'INFORMATION TECHNOLOGY', 'IT', NULL, 4, 'A'),
(32, 'LOGISTICS', 'LOGISTICS', NULL, 4, 'A'),
(33, 'PROCESSING', 'PROCESSING', NULL, 4, 'A'),
(34, 'PRODUCTION', 'PRODUCTION', NULL, 4, 'A'),
(35, 'SALES', 'SALES', NULL, 4, 'A'),
(36, 'RESEARCH AND DEVELOPMENT', 'R&D', NULL, 4, 'A'),
(37, 'MANAGEMENT', 'MANAGEMENT', NULL, 4, 'A'),
(38, 'HUMAN RESOURCE', 'HR', NULL, 4, 'A'),
(39, 'FOUNDATION SEEDS', 'FS', NULL, 4, 'A'),
(40, 'Biotech Services', 'BTS', NULL, 1, 'A'),
(41, 'QUALITY ASSURANCE', 'QA', NULL, 4, 'A'),
(42, 'SEED PRODUCTION RESEARCH', 'SPR', NULL, 4, 'A'),
(44, 'Breeder Seed', 'BRS', NULL, 1, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_dept_shortcodes`
--

CREATE TABLE `master_dept_shortcodes` (
  `DeptShortId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `ShortCode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL COMMENT 'AXAUESRUser_Id',
  `CreatedDate` date NOT NULL,
  `LastUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_designation`
--

CREATE TABLE `master_designation` (
  `DesigId` int(11) NOT NULL,
  `DesigName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DesigCode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DepartmentId` int(11) DEFAULT NULL,
  `CompanyId` int(11) NOT NULL,
  `DesigStatus` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'A-active,D-deactive,De-delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_designation`
--

INSERT INTO `master_designation` (`DesigId`, `DesigName`, `DesigCode`, `DepartmentId`, `CompanyId`, `DesigStatus`) VALUES
(1, 'Principal Breeder', 'PBDR', 2, 1, 'A'),
(2, 'Senior Breeder', 'SR BDR', 2, 1, 'A'),
(3, 'Breeder', 'BDR', 2, 1, 'A'),
(4, 'JR. BREEDER', 'JR BDR', 2, 1, 'A'),
(5, 'Assistant Breeder', 'ASST BDR', 2, 1, 'A'),
(6, 'Research Associate', 'RESEARCH  ASSOC', 2, 1, 'A'),
(7, 'Research Assistant', 'RESEARCH ASST', 2, 1, 'A'),
(8, 'OFFICE ASSISTANT FINANCE', 'OFF ASST FINANCE', 8, 1, 'A'),
(9, 'Admin Assistant ', 'ADMIN ASST', 11, 1, 'A'),
(10, 'Field Assistant', 'FIELD ASST', 25, 1, 'A'),
(11, 'RESEARCH SUPPORT COORDINATOR', 'RSC', 2, 1, 'A'),
(12, 'Biotechnologist', 'BIOTECH NOLOGIST', 2, 1, 'A'),
(13, 'Agronomist', 'AGRO NOMIST', 2, 1, 'A'),
(14, 'PATHOLOGIST', 'PATHO LOGIST', 2, 1, 'A'),
(15, 'Entologist', 'ENTO LOGIST', 2, 1, 'A'),
(16, 'Assistant biotechnologist', 'ASST BIOTECH', 2, 1, 'A'),
(17, 'Assistant Agronomist', 'ASST AGRO', 2, 1, 'A'),
(18, 'Assistant Pathologist', 'ASST PATHO', 2, 1, 'A'),
(19, 'Assistant Entologist', 'ASST ENTO', 2, 1, 'A'),
(20, 'Assistant Product Development Executive', 'ASST PDE', NULL, 1, 'A'),
(21, 'LAB SUPERVISOR', 'LAB SUP', 2, 1, 'A'),
(22, 'LAB ASSISTANT', 'LAB ASST', 2, 1, 'A'),
(23, 'PRODUCT DEVELOPMENT MANAGER', 'PRODUCT DEV MGR', 3, 1, 'A'),
(24, 'PRODUCT DEVELOPMENT EXECUTIVE', 'PRODUCT DEV EXE', 3, 1, 'A'),
(25, 'SENIOR PRODUCTION MANAGER', 'SR PRODUCTION MGR', 4, 1, 'A'),
(26, 'PRODUCTION MANAGER', 'PRODUCTION MGR', 4, 1, 'A'),
(27, 'SR. PRODUCTION OFFICER', 'SR PRODUCTION OFF', 4, 1, 'A'),
(28, 'Assistant Manager Plant ', 'ASST MGR', 5, 1, 'A'),
(29, 'PRODUCTION OFFICER', 'PRODUCTION OFF', 4, 1, 'A'),
(30, 'Assistant Production Officer ', 'ASST PRODUCTION OFF', 4, 1, 'A'),
(31, 'Field Supervisor', 'FIELD SUP', 25, 1, 'A'),
(32, 'Data Entry Operator Production', 'DEO PRODUCTION', 4, 1, 'A'),
(33, 'GENERAL MANAGER QUALITY CONTROL', 'GM QC', NULL, 1, 'A'),
(34, 'Assistant General Manager Quality Control', 'AGM QC', NULL, 1, 'A'),
(35, 'MANAGER QUALITY CONTROL', 'MGR QC', NULL, 1, 'A'),
(36, 'Assistant Manager Quality Control', 'ASST MGR QC', NULL, 1, 'A'),
(37, 'QUALITY CONTROL EXECUTIVE', 'QC EXE', 24, 1, 'A'),
(38, 'SENIOR SUPERVISOR QUALITY CONTROL', 'SR SUP QC', NULL, 1, 'A'),
(39, 'SUPERVISOR QUALITY CONTROL', 'SUP QC', 24, 1, 'A'),
(40, 'Assistant Quality Control', 'ASST QC ', 24, 1, 'A'),
(41, 'General Manager Plant ', 'GM PLANT', 5, 1, 'A'),
(42, 'Assistant General Manager Production', 'ASST GM', 4, 1, 'A'),
(43, 'PLANT MANAGER', 'PLANT MGR', 5, 1, 'A'),
(44, 'Deputy Manager Plant Operations ', 'DM PLANT OP', 5, 1, 'A'),
(45, 'Technical Lead ', 'TL', 5, 1, 'A'),
(46, 'SENIOR PLANT EXECUTIVE', 'SR PLANT EXE', 5, 1, 'A'),
(47, 'MAINTENANCE EXECUTIVE', 'MAIN EXE', 5, 1, 'A'),
(48, 'Senior Plant Engineer', 'SR PLANT ENG', 5, 1, 'A'),
(49, 'PLANT EXECUTIVE', 'PLANT EXE', 5, 1, 'A'),
(50, 'Plant Engineer', 'PLANT ENG', 5, 1, 'A'),
(51, 'SENIOR SUPERVISOR MAINTENANCE', 'SR SUP MAIN', 5, 1, 'A'),
(52, 'SENIOR SUPERVISOR STORES', 'SR SUP STORE', 5, 1, 'A'),
(53, 'Assistant Plant Operator ', 'ASST PLANT OP', 5, 1, 'A'),
(54, 'SUPERVISOR MAINTENANCE', 'SUP MAIN', 5, 1, 'A'),
(55, 'SENIOR ELECTRICIAN', 'SR ELC', 5, 1, 'A'),
(56, 'SUPERVISOR', 'SUP', 5, 1, 'A'),
(57, 'Plant Operator', 'PLANT OP', 5, 1, 'A'),
(58, 'TECHNICIAN', 'TECH NICIAN', 5, 1, 'A'),
(59, 'Electrician', 'ELEC TRICIAN', 5, 1, 'A'),
(60, 'Assistant Electrician', 'ASST ELC', 5, 1, 'A'),
(62, 'JUNIOR ELECTRICIAN', 'JU ELC', 5, 1, 'A'),
(63, 'General Manager Sales', 'GM SALES', 6, 1, 'A'),
(64, 'VP SALES', 'VP SALES', 6, 1, 'A'),
(65, 'Zonal Business Manager', 'ZBM', 6, 1, 'A'),
(66, 'Regional Business Manager', 'RBM', 6, 1, 'A'),
(67, 'Area Business Manager', 'ABM', 6, 1, 'A'),
(68, 'Territory Business Manager', 'TBM', 6, 1, 'A'),
(69, 'Sales Executive', 'SALES EXE', 6, 1, 'A'),
(70, 'SALES OFFICER', 'SALES OFF', 6, 1, 'A'),
(71, 'SALES OFFICER TRAINEE', 'SALES OFF TRA', 6, 1, 'A'),
(72, 'General Manager Marketing ', 'GM MARK', 12, 1, 'A'),
(73, 'VP MARKETING', 'VP MARK', 12, 1, 'A'),
(74, 'PRODUCT MANAGER', 'PDT MGR', 12, 1, 'A'),
(75, 'MARKETING SERVICES MANAGER', 'MARK SER MGR', 12, 1, 'A'),
(76, 'HORTICULTURIST', 'HORTI CULTURIST', NULL, 1, 'A'),
(77, 'MARKETING SERVICES EXECUTIVE', 'MAR SERVICES EXE', 12, 1, 'A'),
(78, 'MARKETING OFFICER', 'MARK OFF', 12, 1, 'A'),
(79, 'General Manager Finance ', 'GM FIN', 8, 1, 'A'),
(80, 'Accounts Manager ', 'ACC MGR', 8, 1, 'A'),
(81, 'MANAGER BANKING OPERATIONS', 'MGR BANK OP', 8, 1, 'A'),
(82, 'Accounts Officer ', 'ACC OFF', 8, 1, 'A'),
(83, 'Senior Executive Accounts', 'SR EXE ACC', 8, 1, 'A'),
(84, 'Account Executive ', 'ACC EXE', 8, 1, 'A'),
(85, 'Account Assistant ', 'ACC ASST', 8, 1, 'A'),
(86, 'SENIOR SOFTWARE PROGRAMMER', 'SR SOFT PROGMER', 9, 1, 'A'),
(87, 'Assistant Softeare Programmer', 'ASST SOFT PROGMER', 9, 1, 'A'),
(88, 'Executive IT', 'IT EXE', 9, 1, 'A'),
(89, 'LEGAL& LIASIONING MANAGER', 'LLM', 10, 1, 'A'),
(90, 'LEGAL OFFICER', 'LEGAL OFF', 10, 1, 'A'),
(91, 'LEGAL EXECUTIVE', 'LEGAL EXE', 10, 1, 'A'),
(92, 'LOGISTICS MANAGER', 'LOGISTIC MGR', 7, 1, 'A'),
(93, 'Assistant Manager', 'ASST MGR', 7, 1, 'A'),
(94, 'LOGISTICS OFFICER', 'LOGISTIC OFF', 7, 1, 'A'),
(95, 'SSENIOR EXECUTIVE LOGISTICS', 'SR EXE LOGISTIC', 7, 1, 'A'),
(96, 'LOGISTICS EXECUTIVE', 'LOGISTIC EXE', 7, 1, 'A'),
(97, 'Assistant Logistic ', 'ASST LOGISTIC', 7, 1, 'A'),
(98, 'HR HEAD', 'HR HEAD', 1, 1, 'A'),
(99, 'SENIOR HR OFFICER', 'SR HR OFF', 1, 1, 'A'),
(100, 'HR OFFICER', 'HR OFF', 1, 1, 'A'),
(101, 'SENIOR HR EXECUTIVE', 'SR HR EXE', 1, 1, 'A'),
(102, 'HR EXECUTIVE', 'HR EXE', 1, 1, 'A'),
(103, 'HR ASSISTANT', 'HR ASST', 1, 1, 'A'),
(104, 'SENIOR ADMIN OFFICER', 'SR ADMAIN OFF', 11, 1, 'A'),
(105, 'Admin Officer', 'ADMIN OFF', 11, 1, 'A'),
(106, 'Senior Admin Executive', 'SR ADMIN EXE', 11, 1, 'A'),
(107, 'Admin Executive', 'ADMIN EXE', 11, 1, 'A'),
(108, 'Admin Support', 'ADMIN SUPPORT', 11, 1, 'A'),
(109, 'Chief Managing Director', 'CMD', 17, 1, 'A'),
(110, 'Director', 'DIRECTOR', 17, 1, 'A'),
(111, 'Assistant Accounts Manager  ', 'ASST ACC MGR', 8, 1, 'A'),
(112, 'Company Secretary', 'COMPANY SECRETARY', 8, 1, 'A'),
(113, 'Driver', 'DRIVER', 11, 1, 'A'),
(114, 'Front Office Executive', 'FRONT OFF EX', 11, 1, 'A'),
(115, 'PRODUCTION HEAD', 'PRODUCTION HEAD', 4, 1, 'A'),
(116, 'RESEARCH & DEVELOPMENT HEAD', 'R&D HEAD', 2, 1, 'A'),
(117, 'SALES & MARKETING HEAD', 'SALES & MARKETING HEAD', 6, 1, 'A'),
(118, 'LOGISTICS EXECUTIVE TRANSPORTATION', 'LOGISTICS EXE TRANSPOR', 7, 1, 'A'),
(119, 'SUPERVISOR STORE', 'SUP STORE', 5, 1, 'A'),
(120, 'WORKMAN', 'WORKMAN', 5, 1, 'A'),
(121, 'Supervisor Dispatch', 'SUP DISPATCH ', 5, 1, 'A'),
(122, 'Assistant supervisior inventory', 'ASST SUP INVENTORY', 5, 1, 'A'),
(123, 'SUPERVISOR PACKING & MAINTENANCE', 'SUP PACKING  MAIN', 5, 1, 'A'),
(124, 'Assistant Supervisor Stores', 'ASST SUP STORES', 25, 1, 'A'),
(125, 'Assistant Supervisor packing', 'ASST SUP PACKING', 5, 1, 'A'),
(126, 'SUPERVISOR PACKING', 'SUP PACKING', 5, 1, 'A'),
(127, 'Supervisor Inventory', 'SUP INVENTORY', 5, 1, 'A'),
(128, 'PRODUCT DEVELOPMENT AREA MANAGER', 'PRODUCT DEV AREA MGR ', 3, 1, 'A'),
(129, 'PRODUCTION MANAGER OUTSOURCED', 'PRODUCTION MGR OUTSOURCED', 4, 1, 'A'),
(130, 'PRODUCTION FIELD SUPERVISOR', 'PRODUCTION FIELD SUP', 4, 1, 'A'),
(131, 'Field Supervisior R & D ', 'FIELD SUP R&D', 2, 1, 'A'),
(132, 'PRODUCTION FIELD ASSISTANT', 'PRODUCTION FIELD ASST', 4, 1, 'A'),
(133, 'Assistant Manager Foundation Seed', 'ASST MGR FOUNDATION SEED', 25, 1, 'A'),
(134, 'RESEARCH FIELD ASSISTANT', 'RESEARCH FIELD ASST', 2, 1, 'A'),
(135, 'Research Assistant Biotechnologist', 'RESEARCH ASST BIOTECH', 2, 1, 'A'),
(136, 'Research Associate Vegetable Breedi', 'RESEARCH ASSOC VEG BDRING', 2, 1, 'A'),
(137, 'RESEARCH FIELD ASSISTANT TRAINEE', 'RESEARCH FIELD ASST TRAINEE', 2, 1, 'A'),
(138, 'Data Entry Operator Sales ', 'DEO SALES', 6, 1, 'A'),
(139, 'Data Entry Operator Admin', 'DEO ADMIN', 11, 1, 'A'),
(140, 'Data Entry Operator HR', 'DEO HR', 1, 1, 'A'),
(141, 'Data Entry Operator Logistics ', 'DEO LOGISTICS', 7, 1, 'A'),
(142, 'Data Entry Operator Processing', 'DEO PROCESSING', 5, 1, 'A'),
(143, 'Data Entry Operator Finance', 'DEO FINANCE', 8, 1, 'A'),
(144, 'SENIOR SUPERVISOR DISPATCH', 'SR SUP DISPATCH', 5, 1, 'A'),
(145, 'PLANT SUPERVISOR', 'PLANT SUP', 5, 1, 'A'),
(146, 'Assistant Supervisior', 'ASST SUP', 5, 1, 'A'),
(147, 'OFFICE ASSISTANT ADMIN', 'OFF ASST ADMIN', 11, 1, 'A'),
(148, 'OFFICE ASSISTANT LOGISTICS', 'OFF ASST LOGISTICS', 7, 1, 'A'),
(149, 'Assistant Manager Product Development', 'ASST MGR PD', 3, 1, 'A'),
(150, 'JUNIOR SEED TECHNOLOGIST', 'JU SEED TECHNOLOGIST', 24, 1, 'A'),
(151, 'SENIOR ACCOUNT ASSISTANT', 'SR ACC OFF', 8, 1, 'A'),
(152, 'PRODUCTION FIELD ASSISTANT', 'PRODUCTION FIELD ASST', 13, 2, 'A'),
(153, 'Sr. ACCOUNTS EXECUTIVE', 'SR ACC EXE', 13, 2, 'A'),
(154, 'OFFICE ASSISTANT', 'OFF ASST', 14, 2, 'A'),
(155, 'ACCOUNT ASSISTANT', 'ACC ASST', 16, 2, 'A'),
(156, 'Territory Manager Production', 'TM PRODUCTION', 4, 1, 'A'),
(157, 'CHIEF MANAGING DIRECTOR ', 'CMD', NULL, 2, 'A'),
(158, 'DIRECTOR', 'DIRECTOR', NULL, 2, 'A'),
(159, 'HEAD OF DEPARTMENT', 'HOD', NULL, 2, 'A'),
(160, 'Business Head', 'BUSINESS HEAD', 21, 3, 'A'),
(161, 'Accounts Executive', 'ACCOUNTS EXE', 20, 3, 'A'),
(162, 'Technical Executive', 'TECHNICAL EXE', 19, 3, 'A'),
(163, 'Customer Service Executive', 'CUSTOMER SER EXE', 26, 3, 'A'),
(164, 'Sr. Executive Production', 'SR. EXE PRODUCTION', 21, 3, 'A'),
(165, 'Director', 'DIRECTOR', 23, 3, 'A'),
(166, 'Chief Managing Director', 'CMD', 23, 3, 'A'),
(167, 'GENERAL MANAGER QUALITY ASSURANCE', 'GM QA', 24, 1, 'A'),
(168, 'PRODUCTION OFFICER FOUNDATION ', 'PRODUCTION OFF FS', 25, 1, 'A'),
(169, 'Production Trainee', 'PROD.TRA.', 25, 1, 'A'),
(170, 'JUNIOR SEED TECHNOLOGIST', 'JR.SD', NULL, 1, 'A'),
(171, 'Managing Director', 'MD', 17, 1, 'A'),
(172, 'MANAGING DIRECTOR', 'MD', 17, 1, 'A'),
(173, 'NATIONAL SALES LEAD', 'NSL', 6, 1, 'A'),
(174, 'SALES TRAINEE', 'ST', 6, 1, 'A'),
(175, 'PRODUCT DEVELOPMENT TRAINEE', 'PDT', 3, 1, 'A'),
(176, 'RESEARCH ASSISTANT TRAINEE', 'RAT', 2, 1, 'A'),
(177, 'RESEARCH ASSOCIATE TRAINEE', 'RESEARCH ASSO. TRA.', 2, 1, 'A'),
(178, 'SEED PRODUCTION RESEARCH TRAINEE', 'SPR TRA.', 4, 1, 'A'),
(179, 'PRODUCT DEVELOPMENT OFFICER', 'PDO', 3, 1, 'A'),
(180, 'Sr. Production Executive Trainee', 'SR. PET', 21, 3, 'A'),
(181, 'Manager sales  Technical Services', 'MANGR. SL TS', 19, 3, 'A'),
(182, 'Assistant Breeder Trainee', 'ASST.BREED.TRAN.', 2, 1, 'A'),
(183, 'SR.SUPERVISOR PHYSIOLOGICAL QUALITY', 'SR. SPQ', 24, 1, 'A'),
(184, 'RESEARCH ASSOCIATE BIOTECHNOLOGY TRAINEE', 'RESEARCH ASSO. BIOTECH.TRA', 2, 1, 'A'),
(185, 'RESEARCH ASSISTANT BIOTECHNOLOGY TRAINEE', 'RESEARCH ASST. BIOTECH. TRA', 2, 1, 'A'),
(186, 'Production Executive', 'PROD. EXE', 4, 1, 'A'),
(187, 'Foundation Seed Trainee ', 'FOUND.SEEED TRA.', 25, 1, 'A'),
(188, 'Assistant Admin', 'ASS.ADMIN', 11, 1, 'A'),
(189, 'SENIOR EXECUTIVE ADMIN', 'SR. EXE.ADMIN', 11, 1, 'A'),
(190, 'Executive Admin', 'EXE.ADMIN', 11, 1, 'A'),
(191, 'SENIOR EXECUTIVE ACCOUNTS', 'SR.EXE.ACC', 8, 1, 'A'),
(192, 'Assistant Accounts ', 'ASST.ACC.', 8, 1, 'A'),
(193, 'Executive Accounts ', 'EXE.ACC.', 8, 1, 'A'),
(194, 'Assistant General Manger', 'ASST.GM', 8, 1, 'A'),
(195, 'General Manager ', 'GM', 25, 1, 'A'),
(196, 'Senior Executive Production', 'SR.EXE.PROD', 25, 1, 'A'),
(197, 'MANAGER FOUNDATION SEED', 'MGR. FS', 25, 1, 'A'),
(198, 'Senior Executive HR', 'SR.EXE.HR', 1, 1, 'A'),
(199, 'Assistant Manager HR', 'ASST.MGR.HR', 1, 1, 'A'),
(200, 'ASSISTANT HR', 'ASST.HR', 1, 1, 'A'),
(201, 'SENIOR EXECUTIVE IT', 'SR.EXE.IT', 9, 1, 'A'),
(202, 'Executive IT', 'EXE.IT', 9, 1, 'A'),
(203, 'Executive Application Development ', 'EXE.APP.DEV.', 9, 1, 'A'),
(204, 'SENIOR EXECUTIVE LEGAL', 'SR.EXE.LG', 10, 1, 'A'),
(205, 'OFFICE ASSISTANT LOGISTICS', 'OA.LOG.', NULL, 1, 'A'),
(206, 'SENIOR MANAGER LOGISTICS', 'SR. MGR. LOG', 7, 1, 'A'),
(207, 'Executive Logistics', 'EXE.LOG', 7, 1, 'A'),
(208, 'SENIOR EXECUTIVE LOGISTICS', 'SR.EXE.LOG', 7, 1, 'A'),
(209, 'SENIOR SUPERVISOR STORES', 'SR.SUP.ST.', NULL, 1, 'A'),
(210, 'Inventory supervisior', 'INV.SUP.', 5, 1, 'A'),
(211, 'STORE ASSISTANT SUPERVISOR', 'ST.ASST.SUP.', 5, 1, 'A'),
(212, 'Area Technical Manager', 'ATM. EAST', 3, 1, 'A'),
(213, 'Senior Executive Technical', 'SR.EXE.TECH', 3, 1, 'A'),
(214, 'Territory Technical Manager', 'TERR.TECH.MGR', 3, 1, 'A'),
(215, 'Trial Executive (Product Development)', 'T.EXE', 3, 1, 'A'),
(216, 'SUPPLY CHAIN LEAD', 'SCL', NULL, 1, 'A'),
(217, 'Executive FS', 'EXE FS', 25, 1, 'A'),
(218, 'SR EXECUTIVE ', 'SR EXE', 25, 1, 'A'),
(219, 'Executive ', 'EXE', 25, 1, 'A'),
(220, 'SUPPLY CHAIN LEAD', 'SCL', 4, 1, 'A'),
(221, 'Assistant manager', 'ASST MGR', 25, 1, 'A'),
(222, 'Executive Production (Operative)', 'EXE.PROD.', 4, 1, 'A'),
(223, 'SENIOR EXECUTIVE PRODUCTION (OPERAT', 'SR.EXE.PROD', 4, 1, 'A'),
(224, 'MANAGER', 'MGR', 25, 1, 'A'),
(225, 'Field Assistant Production', 'FA.PROD', 4, 1, 'A'),
(226, 'Field Supervisor Production', 'FS.PROD.', 4, 1, 'A'),
(227, 'Territory Manager Production', 'TERR.MGR.PROD', 4, 1, 'A'),
(228, 'Assistant Territory Manager', 'ASST.TERR.MGR', 4, 1, 'A'),
(229, 'SENIOR MANAGER', 'SR MGR', 25, 1, 'A'),
(230, 'SENIOR FIELD ASSISTANT PRODUCTION', 'SR.FA.PROD.', 4, 1, 'A'),
(231, 'Assistant General Manger', 'AGM', 25, 1, 'A'),
(232, 'PRODUCTION LEAD ', 'PROD LD', NULL, 1, 'A'),
(233, 'SUPPLY CHAIN LEAD', 'SCL', 25, 1, 'A'),
(234, 'Assistant ', 'ASST', 24, 1, 'A'),
(235, 'SUPERVISOR', 'SUP', 24, 1, 'A'),
(236, 'LEAD', 'LD', 24, 1, 'A'),
(237, 'Executive Quality Assurance', 'EXE.QA', 24, 1, 'A'),
(238, 'Assistant Quality Assurance', 'ASST.QA', 24, 1, 'A'),
(239, 'Senior Executive Quality Assurance', 'SR.EXE.QA', 24, 1, 'A'),
(240, 'SCIENTIST TRIALS', 'SC.TRA', 2, 1, 'A'),
(241, 'RESEARCH LEAD', 'RL', 2, 1, 'A'),
(242, 'Field Supervisior Research', 'FS.RESCH', 2, 1, 'A'),
(243, 'SCIENTIST AGRONOMY', 'SC.AGRO.', 2, 1, 'A'),
(244, 'Breeding Support Coordinator', 'BRE.SUP.CORD', 2, 1, 'A'),
(245, 'SCIENTIST BIOTECHNOLOGY', 'SC.BIOTECH.', 2, 1, 'A'),
(247, 'SENIOR FIELD ASSISTANT R&D', 'SR.FD RESCH', 2, 1, 'A'),
(248, 'LAB ASSISTANT R&D', 'LA.RESCH', 2, 1, 'A'),
(249, 'Field Assistant R&D', 'FA RESCH', 2, 1, 'A'),
(250, 'Assistant Scientist Pathology', 'ASST.SC.PATHO', 2, 1, 'A'),
(251, 'TERRITORY MANAGER', 'TERR MGR ', 4, 1, 'A'),
(252, 'TRAINEE', 'TRA', 12, 1, 'A'),
(253, 'SENIOR FIELD ASSISTANT', 'SR FA', 2, 1, 'A'),
(254, 'Senior Sales Executive', 'SR.SL.EXE', 6, 1, 'A'),
(255, 'Senior Territory Sales Executive', 'SR.TRR.SE', 6, 1, 'A'),
(256, 'SALES EXECUTIVE', 'SLE', 6, 1, 'A'),
(257, 'Territory Sales Executive', 'TERR.SL.EXE', 6, 1, 'A'),
(258, 'Business Lead ', 'BL', 6, 1, 'A'),
(259, 'Assistant Scientist', 'ASST SNT ', 2, 1, 'A'),
(260, 'RESEARCH ASSOCIATE BIOTECHNOLOGY', 'RESC ASSO BIO', 2, 1, 'A'),
(261, 'Research Associate Pathology', 'RESC ASSO PAT', 2, 1, 'A'),
(262, 'RESEARCH ASSOCIATE ENTOMOLOGY', 'RESC ASSO ENT', 2, 1, 'A'),
(263, 'SCIENTIST PATHOLOGY', 'SC PAT', 2, 1, 'A'),
(264, 'SCIENTIST ENTOMOLOGY', 'SC ENT ', 2, 1, 'A'),
(265, 'SENIOR SCIENTIST BIOTECHNOLOGY', 'SR SC BIO', 2, 1, 'A'),
(266, 'Senior Scientist Pathology', 'SR SC PAT', 2, 1, 'A'),
(267, 'SENIOR SCIENTIST ENTOMOLOGY', 'SR SC ENT', 2, 1, 'A'),
(268, ' Principal Scientist Biotechnology', 'PR SC BIO', 2, 1, 'A'),
(269, ' PRINCIPAL SCIENTIST PATHOLOGY', 'PR SC PAT', 2, 1, 'A'),
(270, ' PRINCIPAL SCIENTIST  ENTOMOLOGY', 'PR SC ENT ', 2, 1, 'A'),
(271, 'HEAD VEGETABLE CROP', 'HD VEG CR', 2, 1, 'A'),
(272, 'Head Field Crop', 'HD FLD CR', 2, 1, 'A'),
(273, 'RESEARCH COORDINATOR', 'RESC COO', 2, 1, 'A'),
(274, ' LEAD VEGETABLE CROP', 'LD VEG CR', 2, 1, 'A'),
(275, 'LEAD FIELD CROP', 'LD FLD CR', 2, 1, 'A'),
(276, 'Head ', 'HD', 2, 1, 'A'),
(278, 'Head Research & Development', 'HD.R&D', 2, 1, 'A'),
(279, 'HEAD SUPPLY CHAIN', 'HD.SUPP. CHN', 24, 1, 'A'),
(280, 'Lead R&D (Vegetables)', 'LD.R&D(Veg)', 2, 1, 'A'),
(281, 'General Manager HR ', 'GM-HR', 1, 1, 'A'),
(282, 'General Manager Sales', 'GM-SL', NULL, 1, 'A'),
(283, 'Business Head', 'BH', 12, 1, 'A'),
(284, 'Assistant General Manager Accounts ', 'ASST.GM ACC', 8, 1, 'A'),
(285, 'Executive Technical', 'EXE.TECH', 3, 1, 'A'),
(286, 'Sales Executive Trainee', 'SLE.TRA.', 6, 1, 'A'),
(287, 'Trial Executive Trainee', 'T EXE TRA', 3, 1, 'A'),
(288, 'PRODUCTION OFFICER-QUALITY ASSURANCE', 'PROD. OFF.-QA', 4, 1, 'A'),
(289, 'SENIOR EXECUTIVE PRODUCTION-FIELD QUALITY', 'SR. EXE.PROD.-FQ', 4, 1, 'A'),
(290, 'Field Assistant Production Trainee', 'FA.PROD.TRA ', 25, 1, 'A'),
(291, 'Field Assistant Production Trainee', 'FA. PROD.TRA', NULL, 1, 'A'),
(292, 'Assistant Scientist Plant Pathology', 'ASS SC PL PAT', 2, 1, 'A'),
(293, 'REGIONAL MANAGER', 'RM', 3, 1, 'A'),
(294, 'SCIENTIST PLANT PATHOLOGY', 'SC PL PAT', 2, 1, 'A'),
(295, 'CUSTOMER SUPPORT EXECUTIVE & LOGISTICS', 'CSEXE.&LOGISTICS', 26, 3, 'A'),
(296, 'Technical Executive Trainee', 'TECHNICAL EXE TRAINEE', 19, 3, 'A'),
(297, 'National Head', 'NATIONAL HEAD', 19, 3, 'A'),
(298, 'Regional Manager (Product Development)', 'RMPD', 3, 1, 'A'),
(299, 'TRainee Seed Technology', 'Tra.Seed Tech.', 24, 1, 'A'),
(300, 'Quality Assurance Trainee', 'QA Trainee', 24, 1, 'A'),
(301, 'Executive HR', 'Exe. HR', 1, 1, 'A'),
(302, 'Coordinator Sales', 'COORDINATOR SALES', NULL, 1, 'A'),
(303, 'Regional Technical Manager', 'RTM', 3, 1, 'A'),
(304, 'MARKETING EXECUTIVE TRAINEE', 'MTRA', 12, 1, 'A'),
(305, 'GENERAL MANAGER BUSINESS DEVELOPMENT', 'GMBD', 6, 1, 'A'),
(306, 'Executive Production', 'Exe.Prod', 4, 1, 'A'),
(307, 'Field Assistant Trainee R&D', 'FA.Trainee R&D', 2, 1, 'A'),
(308, 'OFFICE CUM LAB ASSISTANT TRAINEE', 'Off. Cum Lab Asst. Tra.', 11, 1, 'A'),
(309, 'LEAD PRODUCTION', 'Lead Production', 25, 1, 'A'),
(310, 'HEAD SUPPLY CHAIN', 'HSC', 25, 1, 'A'),
(311, 'SUPPORT HR', 'SUPPORT HR', 1, 1, 'A'),
(312, 'Manager HR', 'MANAGER HR', 1, 1, 'A'),
(313, 'SR. MANAGER HR', 'SR MANAGER HR', 1, 1, 'A'),
(314, 'Assistant General Manager HR ', 'ASST GENERAL MANAGER HR', 1, 1, 'A'),
(315, 'Functional Lead ', 'FUNCTIONAL LEAD', 11, 1, 'A'),
(316, 'NATIONAL LEAD', 'NATIONAL LEAD', 11, 1, 'A'),
(317, 'Trainee HR', 'TRAINEES HR', 1, 1, 'A'),
(318, 'General Manager IT', 'GM IT', 9, 1, 'A'),
(319, 'Assistant General Manager IT', 'ASST GM IT', 9, 1, 'A'),
(320, 'SENIOR MANAGER IT', 'SENIOR MANAGER IT', 9, 1, 'A'),
(321, 'Manager IT', 'MANAGER IT', 9, 1, 'A'),
(322, 'MANAGER APPLICATION DEVELOPMENT', 'MANAGER AD', 9, 1, 'A'),
(323, 'MANAGER PROJECT LEAD', 'MANAGER PROJECT LEAD', 9, 1, 'A'),
(324, 'Asst Manager Application Development', 'ASST MANAGER AD', 9, 1, 'A'),
(325, 'Assistant Manager IT', 'ASST MANAGER IT', 9, 1, 'A'),
(326, 'SENIOR EXECUTIVE APPLICATION DEVELOPMENT', 'SENIOR EXECUTIVE AD', 9, 1, 'A'),
(327, 'Assistant IT ', 'ASST IT', 9, 1, 'A'),
(328, 'SUPPORT IT', 'SUPPORT IT', 9, 1, 'A'),
(329, 'Trainee IT', 'TRAINEE IT', 9, 1, 'A'),
(330, 'Data Entry Operator IT', 'DEO IT', 9, 1, 'A'),
(331, 'SUPPORT LEGAL', 'SUPPORT LEGAL', 10, 1, 'A'),
(332, 'Assistant Legal ', 'ASST LEGAL', 10, 1, 'A'),
(333, 'Trainee Legal', 'TRAINEE LEGAL', 10, 1, 'A'),
(334, 'Data Entry Operator Legal', 'DEO LEGAL', 10, 1, 'A'),
(335, 'Executive Legal', 'EXECUTIVE LEGAL', 10, 1, 'A'),
(336, 'Assistant Manager Legal ', 'ASST MANAGER LEGAL', 10, 1, 'A'),
(337, 'MANAGER LEGAL', 'MANAGER LEGAL', 10, 1, 'A'),
(338, 'SENIOR MANAGER LEGAL', 'SENIOR MANAGER LEGAL', 10, 1, 'A'),
(339, 'Assistant General Manager Legal ', 'ASST GENERAL MANAGER LEGAL', 10, 1, 'A'),
(340, 'General Manager Legal', 'GENERAL MANAGER LEGAL', 10, 1, 'A'),
(341, 'SUPPORT LOGISTIC', 'SUPPORT LOGISTIC', 7, 1, 'A'),
(342, 'Trainee Logistics', 'TRAINEE LOGISTIC', 7, 1, 'A'),
(343, 'Assistant Manager Logistics ', 'ASST MANAGER LOGISTIC', 7, 1, 'A'),
(344, 'MANAGER LOGISTIC', 'MANAGER LOGISTIC', 7, 1, 'A'),
(345, 'Asst General Manager Logistic', 'ASST GENERAL MANAGER LOGISTIC', 7, 1, 'A'),
(346, 'General Manager Logistics ', 'GENERAL MANAGER LOGISTIC', 7, 1, 'A'),
(347, 'MARKETING EXECUTIVE', 'MARKETING EXECUTIVE', 12, 1, 'A'),
(348, 'SENIOR MARKETING EXECUTIVE', 'SENIOR MARKETING EXECUTIVE', 12, 1, 'A'),
(349, 'SENIOR MARKETING SERVICE EXECUTIVE', 'SENIOR MARKETING SERVICE EXECUTIVE', 12, 1, 'A'),
(350, 'MANAGER MARKETING SERVICE', 'MANAGER MARKETING SERVICE', 12, 1, 'A'),
(351, 'MANAGER MARKETING COMMUNICATION', 'MANAGER MARKETING COMMUNICATION', 12, 1, 'A'),
(352, 'SENIOR PRODUCT MANAGER', 'SENIOR PRODUCT MANAGER', 12, 1, 'A'),
(353, 'Assistant General Manager Marketing ', 'ASST GENERAL MANAGER MARKETING', 12, 1, 'A'),
(354, 'General Manager Marketing ', 'GENERAL MANAGER MARKETING', 12, 1, 'A'),
(355, 'MARKETING LEAD', 'MARKETING LEAD', 12, 1, 'A'),
(356, 'NATIONAL PRODUCT DEVELOPMENT LEAD', 'NATIONAL PD LEAD', 3, 1, 'A'),
(357, 'General Manager (Product Development) ', 'GM PD', 3, 1, 'A'),
(358, 'Zonal Technical Manager', 'ZTM', 3, 1, 'A'),
(359, 'Asst Manager Quality Assurance', 'ASST MANAGER QA', 24, 1, 'A'),
(360, 'MANAGER QA', 'MANAGER QA', 24, 1, 'A'),
(361, 'SENIOR MANAGER QA', 'SENIOR MANAGER QA', 24, 1, 'A'),
(362, 'Assistant General Manager QA', 'ASST GENERAL MANAGER QA', 24, 1, 'A'),
(363, 'General Manager QA ', 'GENERAL MANAGER QA', 24, 1, 'A'),
(364, 'Lead Quality Assurance', 'LEAD QA', 24, 1, 'A'),
(365, 'Supervisor Quality Assurance', 'SUPERVISOR QA', 24, 1, 'A'),
(366, 'General Manager Production', 'GENERAL MANAGER PRODUCTION', 4, 1, 'A'),
(367, 'GENERAL MANAGER PRODUCTION(VEGITABLE))', 'GM PRODUCTION(VEGITABLE)', 4, 1, 'A'),
(368, 'General Manager Production (Row Crop)', 'GM PRODUCTION(ROW CROP)', 4, 1, 'A'),
(369, 'SENIOR MANAGER PRODUCTION', 'SENIOR MANAGER PRODUCTION', 4, 1, 'A'),
(370, 'Manager Production', 'MANAGER PRODUCTION', 4, 1, 'A'),
(371, 'Asst Manager Production', 'ASST MANAGER PRODUCTION', 4, 1, 'A'),
(372, 'Assistant Territory Manager Production', 'ASST TERRITORY MANAGER PRODUCTION', 4, 1, 'A'),
(373, 'Senior Executive Production', 'SENIOR EXECUTIVE PRODUCTION', 4, 1, 'A'),
(374, 'coordinator Sales ', 'COORDINATOR SALES', 6, 1, 'A'),
(375, 'Zonal Sales Coordinator', 'ZSC', 6, 1, 'A'),
(376, 'SUPPORT ACCOUNT', 'SUPPORT ACCOUNT', 8, 1, 'A'),
(377, 'Trainee Account', 'TRAINEE ACCOUNT', 8, 1, 'A'),
(378, 'Assistant Manager Account', 'ASST MANAGER ACCOUNT', 8, 1, 'A'),
(379, 'MANAGER ACCOUNT', 'MANAGER ACCOUNT', 8, 1, 'A'),
(380, 'SENIOR MANAGER ACCOUNT', 'SENIOR MANAGER ACCOUNT', 8, 1, 'A'),
(381, 'SUPPORT ADMIN', 'SUPPORT ADMIN', 11, 1, 'A'),
(382, 'Trainee Admin', 'TRAINEE ADMIN', 11, 1, 'A'),
(383, 'Assistant Manager Admin', 'ASST MANAGER ADMIN', 11, 1, 'A'),
(384, 'MANAGER ADMIN', 'MANAGER ADMIN', 11, 1, 'A'),
(385, 'SENIOR MANAGER ADMIN', 'SENIOR MANAGER ADMIN', 11, 1, 'A'),
(386, 'Assistant General Manager Admin', 'ASST GM ADMIN', 11, 1, 'A'),
(387, 'General Manager Admin', 'GM ADMIN', 11, 1, 'A'),
(388, 'LEAD PROCESSING', 'LEAD PROCESSING', 5, 1, 'A'),
(389, 'Assistant General Manage Plant ', 'ASST GM PLANT', 5, 1, 'A'),
(390, 'SENIOR MANAGER PLANT', 'SENIOR MANAGER PLANT', 5, 1, 'A'),
(391, 'Deputy Manager Operations (VERTICAL)', 'DEPUTY MGR OPERATIONS(VERTICAL)', 5, 1, 'A'),
(392, 'SENIOR PLANT OPERATOR', 'SENIOR PLANT OPERATOR', 25, 1, 'A'),
(393, 'Assistant Operator', 'ASST OPERATOR', 5, 1, 'A'),
(394, 'Assistant Manager Packing ', 'ASST MGR PKG', 5, 1, 'A'),
(395, 'SR. SUPERVISOR PACKING & MAINTENANCE', 'SR SUP PKG & MAIN', 5, 1, 'A'),
(396, 'Senior Supervisor Inventory', 'SR. SUP. INVEN.', 5, 1, 'A'),
(397, 'SUPERVISOR DISPATCH', 'SUP. DISPATCH', NULL, 1, 'A'),
(398, 'MANAGER', 'MANAGER', 20, 3, 'A'),
(399, 'BUSINESS MANAGER', 'BUSINESS MGR', 19, 3, 'A'),
(400, 'MANAGER PRODUCTION', 'MGR PRODUCCTION', 21, 3, 'A'),
(401, 'ASST MANAGER FINANCE', 'ASST MGR FINANCE', 20, 3, 'A'),
(402, 'ASST MANAGER ACCOUNT', 'ASST MGR ACCOUNT', 20, 3, 'A'),
(403, 'ASST MANAGER SALES', 'ASST MGR SALES', 19, 3, 'A'),
(404, 'ASST MANAGER PRODUCTION', 'ASST MGR PRODUCTION', 21, 3, 'A'),
(405, 'SR PRODUNCTION EXECUTIVE', 'SR PRD EXE', 21, 3, 'A'),
(406, 'SR EXECUTIVE', 'SR EXECUTIVE', 20, 3, 'A'),
(407, 'SR TECHNICAL ', 'SR TECHNICAL ', 19, 3, 'A'),
(408, 'SALES EXECUTIVE', 'SALES EXECUTIVE', 19, 3, 'A'),
(409, 'EXECUTIVE', 'EXECUTIVE', 20, 3, 'A'),
(410, 'TECHNICAL SALES EXECUTIVE', 'TECH SALES EXE', 19, 3, 'A'),
(411, 'TECHNICAL SALES EXECUTIVE TRAINEE', 'TECH SALES EXE TRAINEE', 19, 3, 'A'),
(412, 'PRODUCTION EXECUTIVE', 'PRODUCTION EXECUTIVE', 21, 3, 'A'),
(413, 'Executive Foundation Seed', 'EXE.FS', NULL, 1, 'A'),
(414, 'Area Technical Manager', 'ATM', 6, 1, 'A'),
(415, 'Area Sales Coordinator', 'ASC', 6, 1, 'A'),
(416, 'EXECUTIVE ACCOUNTS', 'EXE.ACC.', 20, 3, 'A'),
(417, 'MANAGER ACCOUNTS', 'MGR. ACC.', 20, 3, 'A'),
(418, 'ASSISTANT MANAGER ACCOUNTS', 'ASST. MGR. ACC.', NULL, 3, 'A'),
(419, 'SENIOR TECHNICAL SALES EXECUTIVE', 'SR.TECH.SL.EXE', 19, 3, 'A'),
(420, 'TECHNICAL SALES EXECUTIVE', 'TECH.SL. EXE', 19, 3, 'A'),
(421, 'TECHNICAL SALES EXECUTIVE TRAINEE', 'TECH. SL. EXE.TRA', 19, 3, 'A'),
(422, 'MANAGER PRODUCTION', 'MGR.PROD', NULL, 3, 'A'),
(423, 'ASSISTANT MANAGER PRODUCTION', 'ASST.MGR.PROD', NULL, 3, 'A'),
(424, 'SENIOR EXECUTIVE PRODUCTION', 'SR. EXE.PROD', NULL, 3, 'A'),
(425, 'EXECUTIVE PRODUCTION', 'EXE.PROD.', NULL, 3, 'A'),
(426, 'SENIOR EXECUTIVE ACCOUNTS', 'SR.EXE.ACC', 20, 3, 'A'),
(427, 'Deputy Manager Production', 'D.MGR.PROD.', 4, 1, 'A'),
(428, 'Executive Production (Warehouse)', 'EXECUTIVE PRODUCTION (Warehouse)', 25, 1, 'A'),
(429, 'Field Assistant Production ', 'FA.PROD', NULL, 1, 'A'),
(430, 'Field Assistant Production', 'FA.PROD', 25, 1, 'A'),
(431, 'Executive Production', 'EXE.PROD', 25, 1, 'A'),
(432, 'OFF.CUM LAB. ASST.', 'OFFICE CUM LAB ASSISTANT ', 11, 1, 'A'),
(433, 'Production Executive Trainee ', 'PRODUCTION EXECUTIVE TRAINEE', 21, 3, 'A'),
(434, 'Executive Stores', 'EXE.STORE', NULL, 1, 'A'),
(435, 'Field Supervisor Production', 'FS.PROD', 25, 1, 'A'),
(436, 'Executive Quality Executive Trail', 'EXECUTIVE QUALITY EXECUTIVE TRAINEE', 24, 1, 'A'),
(437, 'Senior Executive FS', 'SR EXE FS', 25, 1, 'A'),
(438, 'Senior Supervisor Packing', 'SR.SUP.PACK', 5, 1, 'A'),
(439, 'Assistant Scientist Biotechnology', 'ASST.SC.BIOTECH', 2, 1, 'A'),
(440, 'RESEARCH ASSISTANT-  PATHOLOGY', 'RESEARCH ASST. PATHO', 2, 1, 'A'),
(441, 'Assistant Plant Engineer', 'ASSISTANT PLNAT ENGINEER', 5, 1, 'A'),
(442, 'SENIOR SUPERVISOR PROCESSING', 'SR. SUP.PROC', 5, 1, 'A'),
(443, 'Assistant Plant Operator ', 'Asst.Plant Operator', 5, 1, 'A'),
(444, 'Assistant Technician', 'Asst.Tech.', 5, 1, 'A'),
(445, 'Assistant Data Entry Operator', 'Asst. DEO', 5, 1, 'A'),
(446, 'Assistant Plant Engineer ', 'Asst. Plant Engg.', 5, 1, 'A'),
(447, 'SENIOR TECHNICIAN (ITI)', 'Sr.Tech.', 5, 1, 'A'),
(448, 'Assistaant Manager(Technical)', 'Asst. Mgr.Tech.', 5, 1, 'A'),
(449, 'SUPERVISOR ', 'SUPERVISOR', 5, 1, 'A'),
(450, 'PROCESSING LEAD', 'Proc. Lead', 5, 1, 'A'),
(451, 'SENIOR MANAGER(TECHNICAL)', 'Sr.Mngr', 5, 1, 'A'),
(452, 'MANAGER TECHNICAL', 'Mngr.Tech.', 5, 1, 'A'),
(453, 'Deputy Manager (Technical)', 'Dy.Mgr.', 5, 1, 'A'),
(454, 'Deputy Manager Plant', 'Dy.Mgr.Plant', 5, 1, 'A'),
(455, 'MANAGER (TECHNICAL)', 'Mgr.Tech.', 5, 1, 'A'),
(456, 'SENIOR MANAGER (TECHNICAL)', 'Sr. Mgr.(Tech)', 5, 1, 'A'),
(457, 'SENIOR SUPERVISOR', 'Sr. Sup.', 5, 1, 'A'),
(458, 'SENIOR PLANT MANAGER', 'Sr. Mgr Plant', 5, 1, 'A'),
(459, 'Manager Plant', 'Mgr.plant', 5, 1, 'A'),
(460, 'PLANT EXECUTIVE STORES', 'Plant Exe.Stores', 5, 1, 'A'),
(461, 'PLANT EXECUTIVE PACKING', 'Plant Exe. Packing', 5, 1, 'A'),
(462, 'Plant Executive Dispatch', 'Plant Exe. Dispatch', 5, 1, 'A'),
(463, 'Plant Executive Arrival', 'Plant Exe. Arrival', 5, 1, 'A'),
(464, 'Plant Executive Processing', 'Planr Exe. Proc.', 5, 1, 'A'),
(465, 'PLANT EXECUTIVE PROCESSING', 'Plant Exe. Proc', NULL, 1, 'A'),
(466, 'Plant Engineer ', 'Plant Engg.', 25, 1, 'A'),
(467, 'Plant Executive Inventory', 'Plant Exe.Inv.', 5, 1, 'A'),
(468, 'SENIOR MANAGER FOUNDATION SEED', 'SR. MGR.FS', 25, 1, 'A'),
(469, 'Group Product Manager', 'GP.MNG', 12, 1, 'A'),
(470, 'General Manager Business Development', 'GM BD', 12, 1, 'A'),
(471, 'SCIENTIST', 'SCIENTIST', 2, 1, 'A'),
(472, '', '', NULL, 1, 'A'),
(473, 'Assistant Scientist Bioinformatics', 'ASST SC BINFO', 2, 1, 'A'),
(474, 'MANAGER INTERNATIONAL BUSINESS', 'Mgr_IB', 6, 1, 'A'),
(475, 'Area Technical Manager', 'ATM', 3, 1, 'A'),
(476, 'Area Technical Coordinator', 'ATC', 3, 1, 'A'),
(477, 'Assistant General Manager FS', 'AGM-FS', 25, 1, 'A'),
(478, 'PLANT OPERATOR FS ', 'PO-FS', 25, 1, 'A'),
(479, 'Trial Executive Trainee ', 'TET', NULL, 1, 'A'),
(480, 'PRODUCTION TRAINEE', 'PRODUCTION TRA', NULL, 1, 'A'),
(481, 'Assistant Manager SPR', 'AM SPR', 27, 1, 'A'),
(482, 'Field Supervisor SPR', 'FS-SPR', 27, 1, 'A'),
(483, 'Field Assistant SPR ', 'FA-SPR', 27, 1, 'A'),
(484, 'Farm Manager ', 'FM', 28, 1, 'A'),
(485, 'Assistant Manager Sales', 'ASST MGR SL', 6, 1, 'A'),
(486, 'Brand Manager', 'BR MGR', 12, 1, 'A'),
(487, 'MANAGER- INTERNATIONAL AND INSTITUTIONAL BUSINESS', 'Mgr_IB_ISB', 6, 1, 'A'),
(488, 'Assistant Manager Marketing ', 'ASST MGR MKTG', 12, 1, 'A'),
(489, '', '', NULL, 1, 'A'),
(490, 'Senior Executive Corporate Communication', 'SR EXE CORP COM', 12, 1, 'A'),
(491, 'Territory Sales Executive Trainee', 'TSE-TRAINEE', 6, 1, 'A'),
(492, 'Management Trainee-Sales', 'MT-SALES', 6, 1, 'A'),
(493, 'Assistant (Product Development)', 'ASST.PD', 3, 1, 'A'),
(494, 'Assistant Supervisor Stores', 'Asst Sup Stores', NULL, 1, 'A'),
(495, 'Assistant Supervisor-Stores', 'Asst. Sup', 25, 1, 'A'),
(496, 'Trainee Field Supervisor', 'TRA. FIELD.SUP', 4, 1, 'A'),
(497, 'Assistant Territory Manager', 'ATM', 4, 1, 'A'),
(498, '', 'AREA TERRITORY MANAGER ', NULL, 1, 'A'),
(499, 'Area Territory Manager', 'ATM_P', 4, 1, 'A'),
(500, 'ADMIN EXECUTIVE', 'ADMIN EXE', 29, 4, 'A'),
(501, 'ADMIN ASSISTANT', 'ADMIN ASST', 29, 4, 'A'),
(502, 'LOGISTICS EXECUTIVE', 'LOGISTICS EXE', 32, 4, 'A'),
(503, 'SUPERVISOR PACKING', 'SUPERVISOR PACKING', 33, 4, 'A'),
(504, 'DATA ENTRY OPERATOR', 'DEO', 39, 4, 'A'),
(505, 'ASSISTANT PLANT OPERATOR', 'APO', 33, 4, 'A'),
(506, 'DATA ENTRY OPERATOR DISPATCH', 'DEO DISPATCH', 33, 4, 'A'),
(507, 'DATA ENTRY OPERATOR ARRIVAL', 'DEO ARRIVAL', 33, 4, 'A'),
(508, 'ASSISTANT SUPERVISOR', 'ASST SUP', 42, 4, 'A'),
(509, 'ASSISTANT SUPERVISOR PACKING', 'ASST SUP PACKING', 33, 4, 'A'),
(510, 'EXECUTIVE ACCOUNTS', 'EXE ACCOUNTS', 30, 4, 'A'),
(511, 'ASSISTANT ACCOUNTS', 'ASST ACCOUNTS', 30, 4, 'A'),
(512, 'INFORMATION TECHNOLOGY EXECUTIVE', 'IT EXE', 31, 4, 'A'),
(513, 'ASSISTANT SUPERVISOR STORES', 'ASST SUP STORES', 33, 4, 'A'),
(514, '', '', NULL, 4, 'A'),
(515, 'FIELD ASSISTANT PRODUCTION', 'FIELD ASST PROD', 34, 4, 'A'),
(516, 'LAB ASSISTANT', 'LAB ASST', 41, 4, 'A'),
(517, 'LAB ASSISTANT TISSUE CULTURE', 'LAB ASST TISSUE CULTURE', 36, 4, 'A'),
(518, 'LAB ASSISTANT PATHOLOGY', 'LAB ASST PATHOLOGY', 36, 4, 'A'),
(519, 'LAB ASSISTANT BIOCHEMESTRY', 'LAB  ASST BIOCHEMESTRY', 36, 4, 'A'),
(520, 'LAB ASSISTANT BIOTECHNOLOGY', 'LAB ASST BIOTECHNOLOGY', 36, 4, 'A'),
(521, 'BACK OFFICE EXECUTIVE', 'BACK OFFICE EXE', 35, 4, 'A'),
(522, 'BREEDING SUPPORT COORDINATOR', 'BREEDING SUPPORT COORDINATOR', 36, 4, 'A'),
(523, 'LEAD PROCESSING', 'LEAD PROCESSING', 33, 4, 'A'),
(524, 'MANAGER INTERNATIONAL BUSINESS', 'MANAGER INTERNATIONAL BUSINESS', 35, 4, 'A'),
(525, 'PRINCIPAL SCIENTIST BIOTECHNOLOGY', 'PRINCIPAL SCIENTIST BIOTECHNOLOGY', 36, 4, 'A'),
(526, 'ASSTISTANT GENERAL MANAGER ACCOUNTS', 'ASST GENERAL MANAGER ACCOUNTS', 30, 4, 'A'),
(527, 'ASSISTANT GENERAL MANAGER LOGISTIC', 'ASST GENERAL MANAGER LOGISTIC', 32, 4, 'A'),
(528, 'ASSISTANT MANAGER IT', 'ASST MANAGER IT', 31, 4, 'A'),
(529, 'ASSISTANT GENERAL MANGER', 'ASST GENERAL MANGER', 39, 4, 'A'),
(530, 'DEPUTY MANAGER PLANT', 'DEPUTY MANAGER PLANT', 33, 4, 'A'),
(531, 'MANAGER IT', 'MANAGER IT', 31, 4, 'A'),
(532, 'BUSINESS HEAD', 'BUSINESS HEAD', 35, 4, 'A'),
(533, 'DIRECTOR', 'DIRECTOR', 37, 4, 'A'),
(534, 'PLANT EXECUTIVE PROCESSING', 'PLANT EXECUTIVE PROCESSING', 33, 4, 'A'),
(535, 'PLANT EXECUTIVE DISPATCH', 'PLANT EXECUTIVE DISPATCH', 33, 4, 'A'),
(536, 'PLANT EXECUTIVE ARRIVAL', 'PLANT EXECUTIVE ARRIVAL', 33, 4, 'A'),
(537, 'HEAD RESEARCH & DEVELOPMENT', 'HEAD RESEARCH & DEVELOPMENT', 36, 4, 'A'),
(538, 'LEAD R&D (VEGETABLES)', 'LEAD R&D (VEGETABLES)', 36, 4, 'A'),
(539, 'MANAGER HR  ', 'MANAGER HR  ', 38, 4, 'A'),
(540, 'GENERAL MANAGER HR', 'GENERAL MANAGER HR', 38, 4, 'A'),
(541, 'GENERAL MANAGER FINANCE', 'GENERAL MANAGER FINANCE', 30, 4, 'A'),
(542, 'ASSISTANT MANAGER', 'ASST MANAGER', 39, 4, 'A'),
(543, 'HEAD SUPPLY CHAIN', 'HEAD SUPPLY CHAIN', 34, 4, 'A'),
(544, 'SENIOR ADMIN EXECUTIVE', 'SENIOR ADMIN EXE', 29, 4, 'A'),
(545, 'Regional Business Manager- Vegetable Crop', 'RBM-VC', 6, 1, 'A'),
(546, 'Area Business Manager- Field Crop', 'AMB-FC', 6, 1, 'A'),
(547, 'Area Business Manager - Vegetable & Field Crop', 'ABM-VFC', 2, 1, 'A'),
(548, 'REGIONAL BUSINESS MANAGER-FIELD CROP', 'RBM-FC', 6, 1, 'A'),
(549, 'Supervisor Arrival', 'SUP ARR', 5, 1, 'A'),
(550, 'SENIOR PLANT OPERATOR', 'SR PLANT OPR', NULL, 1, 'A'),
(551, 'Deputy Manager QA', 'Dy Mgr QA', 24, 1, 'A'),
(552, 'PRODUCTION TRANINEE', 'PROD.TRA', 25, 1, 'A'),
(553, 'GENERAL MANAGER PRODUCTION', 'GM - PRODUCTION', 34, 4, 'A'),
(554, 'MANAGER PRODUCTION', 'MANAGER PROD', 34, 4, 'A'),
(555, 'DEPUTY MANAGER PRODUCTION', 'DEPUTY MANAGER- PROD', 34, 4, 'A'),
(556, 'ASSISTANT MANAGER PRODUCTION', 'ASST MANAGER PROD', 34, 4, 'A'),
(557, 'SENIOR EXECUTIVE PRODUCTION', 'SENIOR EXE PROD', 34, 4, 'A'),
(558, 'ASSISTANT SUPERVISOR PRODUCTION', 'ASST SUP PROD', 34, 4, 'A'),
(559, 'Area Territory Manager', 'Area Territory Manager', NULL, 4, 'A'),
(560, 'FIELD SUPERVISOR PRODUCTION', 'FIELD SUP PROD', 34, 4, 'A'),
(561, 'EXECUTIVE PRODUCTION', 'EXE PRODUCTION', 34, 4, 'A'),
(562, 'PRODUCTION SUPERVISOR', 'PROD SUP', 34, 4, 'A'),
(563, 'TERRITORY MANAGER PRODUCTION', 'TERR MANAGER PROD', 34, 4, 'A'),
(564, 'OFFICE SUPERVISOR', 'OFFICE SUP', 34, 4, 'A'),
(565, 'PRODUCTION TRAINEE', 'PROD TRAINEE', 34, 4, 'A'),
(566, 'Assistant Territory Manager Production', 'Asst Territory Manager Production', 34, 4, 'A'),
(567, 'Field supervisior PD', 'FIELD SUP', 3, 1, 'A'),
(568, 'Field Assistant PD', 'FA- PD', 3, 1, 'A'),
(569, 'SENIOR PLANT OPERATOR FS', 'SR.PO-FS', 25, 1, 'A'),
(570, 'ASSISTANT MANAGER SERVICES & PRODUCTION ', 'ASST MGR SERV PROD.', 21, 3, 'A'),
(571, 'COMPUTER OPERATOR', 'COM OP', 34, 4, 'A'),
(572, 'Manager Biotech Services - Genome Isolation ', 'MGR BIO SER - GI', 40, 1, 'A'),
(573, 'MANAGER BIOTECH SERVICES- GENOTYPING', 'MGR BIO SER GT', 40, 1, 'A'),
(574, 'Lead Supply Chain', 'LEAD SC', 5, 1, 'A'),
(575, 'Assistant Manager Breeder Seed', 'ASST MGR BRD SEED', 44, 1, 'A'),
(576, 'Office Boy', 'Off Boy', 34, 4, 'A'),
(577, 'Assistant IT', 'Asst IT', 31, 4, 'A'),
(578, 'Supervisor Inventory', 'Sup Inventory', 33, 4, 'A'),
(579, 'PLANT OPERATOR', 'PLANT OP', 33, 4, 'A'),
(580, 'ASSISTANT SUPERVISOR ARRIVAL', 'ASST SUP ARRIVAL', 33, 4, 'A'),
(581, 'SENIOR EXECUTIVE QA', 'SENIOR EXE QA', 41, 4, 'A'),
(582, 'MANAGING DIRECTOR', 'MD', 37, 4, 'A'),
(583, 'Executive Seed Production Research ', 'SPR Exe', 27, 1, 'A'),
(584, 'FIELD ASSISTANT- SPR', 'FA-SPR', 42, 4, 'A'),
(585, 'FIELD ASSISTANT- SPR', 'FA-SPR', NULL, 4, 'A'),
(586, 'ASSISTANT MANAGER- SPR', 'AM - SPR', 42, 4, 'A'),
(587, 'SUPERVISOR- SPR', 'SUP- SPR', 42, 4, 'A'),
(588, 'LEAD QUALITY ASSURANCE', 'LEAD QA', 41, 4, 'A'),
(589, 'PLANT ENGINEER', 'PLANT ENGG', 39, 4, 'A'),
(590, 'Data Entry Operator', 'DEO', 5, 1, 'A'),
(591, 'Senior Data Entry Operator', 'SENIOR DEO', 5, 1, 'A'),
(592, 'Supervisor Production', 'SUP PRODUCTION', 4, 1, 'A'),
(593, 'Supervisor Data Management', 'SUP DATA MGMT', 5, 1, 'A'),
(594, 'Senior Supervisor Production', 'SENIOR SUP PRODUCTION', 4, 1, 'A'),
(595, 'Assistant Executive Production', 'ASST EXE PRODUCTION', 4, 1, 'A'),
(596, 'Assistant Executive- Data Management', 'ASST EXE- DATA MGMT', 5, 1, 'A'),
(597, 'Executive- Data Management', 'EXE- DATA MGMT', 5, 1, 'A'),
(598, 'Senior Executive- Data Management', 'SENIOR EXE- DATA MGMT', 5, 1, 'A'),
(599, 'Assistant General Manager Production', 'ASST GENERAL MANAGER PRODUCTION', 4, 1, 'A'),
(600, 'Group Lead- Production', 'GROUP LEAD- PRODUCTION', 4, 1, 'A'),
(601, 'Lead (Product Development)', 'LEAD PD', 3, 1, 'A'),
(602, 'Deputy General Manager (Product Development)', 'DY. GM PD', 3, 1, 'A'),
(603, 'Zonal Manager (Product Development)', 'ZM PD', 3, 1, 'A'),
(604, 'Area Manager (Product Development)', 'AM PD', 3, 1, 'A'),
(605, 'Area Coordinator (Product Development)', 'AC PD', 3, 1, 'A'),
(606, 'Territory Manager (Product Development)', 'TM PD', 3, 1, 'A'),
(607, 'Senior Executive (Product Development)', 'SR. EXE. PD', 3, 1, 'A'),
(608, 'Executive (Product Development)', 'EXE. PD', 3, 1, 'A'),
(609, 'Supervisor Processing', 'SUP. PROC.', 5, 1, 'A'),
(610, 'Senior Supervisor Data Management', 'SR. SUP. DM', NULL, 1, 'A'),
(611, 'Senior Supervisor Data Management', 'SR. SUP. DATA MGMT', 5, 1, 'A'),
(612, 'Senior Supervisor Arrival', 'SR. SUP. ARR', 5, 1, 'A'),
(613, 'Deputy General Manager (Product Development)', 'DY. GM PD', 3, 1, 'A'),
(614, 'Supervisor Data Management', 'SUP Data MNGM', 25, 1, 'A'),
(615, 'Horticulturist Trainee', 'Horti Trainee', 19, 3, 'A'),
(616, 'Assistant General Manager Accounts', 'AGM-ACC', 20, 3, 'A'),
(617, 'Supervisor', 'SUP', 25, 1, 'A'),
(618, 'Assistant Manager ERP', 'Asst MGR ERP', 9, 1, 'A'),
(619, 'Assistant Territory Manager Production', 'ASST. TMP', 21, 3, 'A'),
(621, 'SENIOR HORTICULTURIST- NURSERY', 'SR. HORTICULTURIST- NURSERY', 21, 3, 'A'),
(622, 'SMS- FRUIT CROPS', 'SMS- FRUIT CROPS', 19, 3, 'A'),
(623, 'HORTICULTURIST- NURSERY', 'HORTICULTURIST- NURSERY', 21, 3, 'A'),
(624, 'HORTICULTURIST- FRUIT CROPS', 'HORTICULTURIST- FC', 21, 3, 'A'),
(625, 'HORTICULTURIST TRAINEE', 'HORTICULTURIST TRAINEE', 21, 3, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_district`
--

CREATE TABLE `master_district` (
  `DistrictId` int(11) NOT NULL,
  `DistrictName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StateId` int(11) NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_district`
--

INSERT INTO `master_district` (`DistrictId`, `DistrictName`, `StateId`, `Status`) VALUES
(1, 'North Andaman', 1, 'A'),
(2, 'South Andaman', 1, 'A'),
(3, 'Nicobar', 1, 'A'),
(4, 'Adilabad', 2, 'D'),
(5, 'Anantapur', 2, 'A'),
(6, 'Chittoor', 2, 'A'),
(7, 'East Godavari', 2, 'A'),
(8, 'Guntur', 2, 'A'),
(9, 'Hyderabad', 2, 'D'),
(10, 'Karimnagar', 2, 'D'),
(11, 'Khammam', 2, 'D'),
(12, 'Krishna', 2, 'A'),
(13, 'Kurnool', 2, 'A'),
(14, 'Mahbubnagar', 2, 'D'),
(15, 'Medak', 2, 'D'),
(16, 'Nalgonda', 2, 'D'),
(17, 'Nizamabad', 2, 'D'),
(18, 'Prakasam', 2, 'A'),
(19, 'Ranga Reddy', 2, 'D'),
(20, 'Srikakulam', 2, 'A'),
(21, 'Sri Potti Sri Ramulu Nellore', 2, 'A'),
(22, 'Vishakhapatnam', 2, 'A'),
(23, 'Vizianagaram', 2, 'A'),
(24, 'Warangal', 2, 'D'),
(25, 'West Godavari', 2, 'A'),
(26, 'YSR Kadapa', 2, 'A'),
(27, 'Anjaw', 3, 'A'),
(28, 'Changlang', 3, 'A'),
(29, 'East Siang', 3, 'A'),
(30, 'East Kameng', 3, 'A'),
(31, 'Kurung Kumey', 3, 'A'),
(32, 'Lohit', 3, 'A'),
(33, 'Lower Dibang Valley', 3, 'A'),
(34, 'Lower Subansiri', 3, 'A'),
(35, 'Papum Pare', 3, 'A'),
(36, 'Tawang', 3, 'A'),
(37, 'Tirap', 3, 'A'),
(38, 'Dibang Valley', 3, 'A'),
(39, 'Upper Siang', 3, 'A'),
(40, 'Upper Subansiri', 3, 'A'),
(41, 'West Kameng', 3, 'A'),
(42, 'West Siang', 3, 'A'),
(43, 'Baksa', 4, 'A'),
(44, 'Barpeta', 4, 'A'),
(45, 'Bongaigaon', 4, 'A'),
(46, 'Cachar', 4, 'A'),
(47, 'Chirang', 4, 'A'),
(48, 'Darrang', 4, 'A'),
(49, 'Dhemaji', 4, 'A'),
(50, 'Dima Hasao', 4, 'A'),
(51, 'Dhubri', 4, 'A'),
(52, 'Dibrugarh', 4, 'A'),
(53, 'Goalpara', 4, 'A'),
(54, 'Golaghat', 4, 'A'),
(55, 'Hailakandi', 4, 'A'),
(56, 'Jorhat', 4, 'A'),
(57, 'Kamrup', 4, 'A'),
(58, 'Kamrup Metropolitan', 4, 'A'),
(59, 'Karbi Anglong', 4, 'A'),
(60, 'Karimganj', 4, 'A'),
(61, 'Kokrajhar', 4, 'A'),
(62, 'Lakhimpur', 4, 'A'),
(63, 'Morigaon', 4, 'A'),
(64, 'Nagaon', 4, 'A'),
(65, 'Nalbari', 4, 'A'),
(66, 'Sivasagar', 4, 'A'),
(67, 'Sonitpur', 4, 'A'),
(68, 'Tinsukia', 4, 'A'),
(69, 'Udalguri', 4, 'A'),
(70, 'Araria', 5, 'A'),
(71, 'Arwal', 5, 'A'),
(72, 'Aurangabad', 5, 'A'),
(73, 'Banka', 5, 'A'),
(74, 'Begusarai', 5, 'A'),
(75, 'Bhagalpur', 5, 'A'),
(76, 'Bhojpur', 5, 'A'),
(77, 'Buxar', 5, 'A'),
(78, 'Darbhanga', 5, 'A'),
(79, 'East Champaran', 5, 'A'),
(80, 'Gaya', 5, 'A'),
(81, 'Gopalganj', 5, 'A'),
(82, 'Jamui', 5, 'A'),
(83, 'Jehanabad', 5, 'A'),
(84, 'Kaimur', 5, 'A'),
(85, 'Katihar', 5, 'A'),
(86, 'Khagaria', 5, 'A'),
(87, 'Kishanganj', 5, 'A'),
(88, 'Lakhisarai', 5, 'A'),
(89, 'Madhepura', 5, 'A'),
(90, 'Madhubani', 5, 'A'),
(91, 'Munger', 5, 'A'),
(92, 'Muzaffarpur', 5, 'A'),
(93, 'Nalanda', 5, 'A'),
(94, 'Nawada', 5, 'A'),
(95, 'Patna', 5, 'A'),
(96, 'Purnia', 5, 'A'),
(97, 'Rohtas', 5, 'A'),
(98, 'Saharsa', 5, 'A'),
(99, 'Samastipur', 5, 'A'),
(100, 'Saran', 5, 'A'),
(101, 'Sheikhpura', 5, 'A'),
(102, 'Sheohar', 5, 'A'),
(103, 'Sitamarhi', 5, 'A'),
(104, 'Siwan', 5, 'A'),
(105, 'Supaul', 5, 'A'),
(106, 'Chandigarh', 6, 'A'),
(107, 'Bastar', 7, 'A'),
(108, 'Bijapur', 7, 'A'),
(109, 'Bilaspur', 7, 'A'),
(110, 'Dantewada', 7, 'A'),
(111, 'Dhamtari', 7, 'A'),
(112, 'Durg', 7, 'A'),
(113, 'Jashpur', 7, 'A'),
(114, 'Janjgir-Champa', 7, 'A'),
(115, 'Korba', 7, 'A'),
(116, 'Koriya', 7, 'A'),
(117, 'Kanker', 7, 'A'),
(118, 'Kabirdham', 7, 'A'),
(119, 'Mahasamund', 7, 'A'),
(120, 'Narayanpur', 7, 'A'),
(121, 'Raigarh', 7, 'A'),
(122, 'Rajnandgaon', 7, 'A'),
(123, 'Raipur', 7, 'A'),
(124, 'Surguja', 7, 'A'),
(125, 'Dadra and Nagar Haveli', 8, 'A'),
(126, 'Daman', 9, 'A'),
(127, 'Diu', 9, 'A'),
(128, 'Central Delhi', 10, 'A'),
(129, 'East Delhi', 10, 'A'),
(130, 'New Delhi', 10, 'A'),
(131, 'North Delhi', 10, 'A'),
(132, 'North East Delhi', 10, 'A'),
(133, 'North West Delhi', 10, 'A'),
(134, 'South Delhi', 10, 'A'),
(135, 'South West Delhi', 10, 'A'),
(136, 'West Delhi', 10, 'A'),
(137, 'North Goa', 11, 'A'),
(138, 'South Goa', 11, 'A'),
(139, 'Ahmedabad', 12, 'A'),
(140, 'Amreli district', 12, 'A'),
(141, 'Anand', 12, 'A'),
(142, 'Banaskantha', 12, 'A'),
(143, 'Bharuch', 12, 'A'),
(144, 'Bhavnagar', 12, 'A'),
(145, 'Dahod', 12, 'A'),
(146, 'The Dangs', 12, 'A'),
(147, 'Gandhinagar', 12, 'A'),
(148, 'Jamnagar', 12, 'A'),
(149, 'Junagadh', 12, 'A'),
(150, 'Kutch', 12, 'A'),
(151, 'Kheda', 12, 'A'),
(152, 'Mehsana', 12, 'A'),
(153, 'Narmada', 12, 'A'),
(154, 'Navsari', 12, 'A'),
(155, 'Patan', 12, 'A'),
(156, 'Panchmahal', 12, 'A'),
(157, 'Porbandar', 12, 'A'),
(158, 'Rajkot', 12, 'A'),
(159, 'Sabarkantha', 12, 'A'),
(160, 'Surendranagar', 12, 'A'),
(161, 'Surat', 12, 'A'),
(162, 'Tapi', 12, 'A'),
(163, 'Vadodara', 12, 'A'),
(164, 'Valsad', 12, 'A'),
(165, 'Ambala', 13, 'A'),
(166, 'Bhiwani', 13, 'A'),
(167, 'Faridabad', 13, 'A'),
(168, 'Fatehabad', 13, 'A'),
(169, 'Gurgaon', 13, 'A'),
(170, 'Hissar', 13, 'A'),
(171, 'Jhajjar', 13, 'A'),
(172, 'Jind', 13, 'A'),
(173, 'Karnal', 13, 'A'),
(174, 'Kaithal', 13, 'A'),
(175, 'Kurukshetra', 13, 'A'),
(176, 'Mahendragarh', 13, 'A'),
(177, 'Mewat', 13, 'A'),
(178, 'Palwal', 13, 'A'),
(179, 'Panchkula', 13, 'A'),
(180, 'Panipat', 13, 'A'),
(181, 'Rewari', 13, 'A'),
(182, 'Rohtak', 13, 'A'),
(183, 'Sirsa', 13, 'A'),
(184, 'Sonipat', 13, 'A'),
(185, 'Yamuna Nagar', 13, 'A'),
(186, 'Bilaspur', 14, 'A'),
(187, 'Chamba', 14, 'A'),
(188, 'Hamirpur', 14, 'A'),
(189, 'Kangra', 14, 'A'),
(190, 'Kinnaur', 14, 'A'),
(191, 'Kullu', 14, 'A'),
(192, 'Lahaul and Spiti', 14, 'A'),
(193, 'Mandi', 14, 'A'),
(194, 'Shimla', 14, 'A'),
(195, 'Sirmaur', 14, 'A'),
(196, 'Solan', 14, 'A'),
(197, 'Una', 14, 'A'),
(198, 'Anantnag', 15, 'A'),
(199, 'Badgam', 15, 'A'),
(200, 'Bandipora', 15, 'A'),
(201, 'Baramulla', 15, 'A'),
(202, 'Doda', 15, 'A'),
(203, 'Ganderbal', 15, 'A'),
(204, 'Jammu', 15, 'A'),
(205, 'Kargil', 36, 'A'),
(206, 'Kathua', 15, 'A'),
(207, 'Kishtwar', 15, 'A'),
(208, 'Kupwara', 15, 'A'),
(209, 'Kulgam', 15, 'A'),
(210, 'Leh', 36, 'A'),
(211, 'Poonch', 15, 'A'),
(212, 'Pulwama', 15, 'A'),
(213, 'Rajouri', 15, 'A'),
(214, 'Ramban', 15, 'A'),
(215, 'Reasi', 15, 'A'),
(216, 'Samba', 15, 'A'),
(217, 'Shopian', 15, 'A'),
(218, 'Srinagar', 15, 'A'),
(219, 'Udhampur', 15, 'A'),
(220, 'Bokaro', 16, 'A'),
(221, 'Chatra', 16, 'A'),
(222, 'Deoghar', 16, 'A'),
(223, 'Dhanbad', 16, 'A'),
(224, 'Dumka', 16, 'A'),
(225, 'East Singhbhum', 16, 'A'),
(226, 'Garhwa', 16, 'A'),
(227, 'Giridih', 16, 'A'),
(228, 'Godda', 16, 'A'),
(229, 'Gumla', 16, 'A'),
(230, 'Hazaribag', 16, 'A'),
(231, 'Jamtara', 16, 'A'),
(232, 'Khunti', 16, 'A'),
(233, 'Koderma', 16, 'A'),
(234, 'Latehar', 16, 'A'),
(235, 'Lohardaga', 16, 'A'),
(236, 'Pakur', 16, 'A'),
(237, 'Palamu', 16, 'A'),
(238, 'Ramgarh', 16, 'A'),
(239, 'Ranchi', 16, 'A'),
(240, 'Sahibganj', 16, 'A'),
(241, 'Seraikela Kharsawan', 16, 'A'),
(242, 'Simdega', 16, 'A'),
(243, 'West Singhbhum', 16, 'A'),
(244, 'Bagalkot', 17, 'A'),
(245, 'Bangalore Rural', 17, 'A'),
(246, 'Bangalore Urban', 17, 'A'),
(247, 'Belgaum', 17, 'A'),
(248, 'Bellary', 17, 'A'),
(249, 'Bidar', 17, 'A'),
(250, 'Bijapur', 17, 'A'),
(251, 'Chamarajnagar', 17, 'A'),
(252, 'Chikkamagaluru', 17, 'A'),
(253, 'Chikkaballapur', 17, 'A'),
(254, 'Chitradurga', 17, 'A'),
(255, 'Davanagere', 17, 'A'),
(256, 'Dharwad', 17, 'A'),
(257, 'Dakshina Kannada', 17, 'A'),
(258, 'Gadag', 17, 'A'),
(259, 'Gulbarga', 17, 'A'),
(260, 'Hassan', 17, 'A'),
(261, 'Haveri district', 17, 'A'),
(262, 'Kodagu', 17, 'A'),
(263, 'Kolar', 17, 'A'),
(264, 'Koppal', 17, 'A'),
(265, 'Mandya', 17, 'A'),
(266, 'Mysore', 17, 'A'),
(267, 'Raichur', 17, 'A'),
(268, 'Shimoga', 17, 'A'),
(269, 'Tumkur', 17, 'A'),
(270, 'Udupi', 17, 'A'),
(271, 'Uttara Kannada', 17, 'A'),
(272, 'Ramanagara', 17, 'A'),
(273, 'Yadgir', 17, 'A'),
(274, 'Alappuzha', 18, 'A'),
(275, 'Ernakulam', 18, 'A'),
(276, 'Idukki', 18, 'A'),
(277, 'Kannur', 18, 'A'),
(278, 'Kasaragod', 18, 'A'),
(279, 'Kollam', 18, 'A'),
(280, 'Kottayam', 18, 'A'),
(281, 'Kozhikode', 18, 'A'),
(282, 'Malappuram', 18, 'A'),
(283, 'Palakkad', 18, 'A'),
(284, 'Pathanamthitta', 18, 'A'),
(285, 'Thrissur', 18, 'A'),
(286, 'Thiruvananthapuram', 18, 'A'),
(287, 'Wayanad', 18, 'A'),
(288, 'Lakshadweep', 19, 'A'),
(289, 'Agar', 20, 'A'),
(290, 'Alirajpur', 20, 'A'),
(291, 'Anuppur', 20, 'A'),
(292, 'Ashok Nagar', 20, 'A'),
(293, 'Balaghat', 20, 'A'),
(294, 'Barwani', 20, 'A'),
(295, 'Betul', 20, 'A'),
(296, 'Bhind', 20, 'A'),
(297, 'Bhopal', 20, 'A'),
(298, 'Burhanpur', 20, 'A'),
(299, 'Chhatarpur', 20, 'A'),
(300, 'Chhindwara', 20, 'A'),
(301, 'Damoh', 20, 'A'),
(302, 'Datia', 20, 'A'),
(303, 'Dewas', 20, 'A'),
(304, 'Dhar', 20, 'A'),
(305, 'Dindori', 20, 'A'),
(306, 'Guna', 20, 'A'),
(307, 'Gwalior', 20, 'A'),
(308, 'Harda', 20, 'A'),
(309, 'Hoshangabad', 20, 'A'),
(310, 'Indore', 20, 'A'),
(311, 'Jabalpur', 20, 'A'),
(312, 'Jhabua', 20, 'A'),
(313, 'Katni', 20, 'A'),
(314, 'Khandwa (East Nimar)', 20, 'A'),
(315, 'Khargone (West Nimar)', 20, 'A'),
(316, 'Mandla', 20, 'A'),
(317, 'Mandsaur', 20, 'A'),
(318, 'Morena', 20, 'A'),
(319, 'Narsinghpur', 20, 'A'),
(320, 'Neemuch', 20, 'A'),
(321, 'Panna', 20, 'A'),
(322, 'Raisen', 20, 'A'),
(323, 'Rajgarh', 20, 'A'),
(324, 'Ratlam', 20, 'A'),
(325, 'Rewa', 20, 'A'),
(326, 'Sagar', 20, 'A'),
(327, 'Satna', 20, 'A'),
(328, 'Sehore', 20, 'A'),
(329, 'Seoni', 20, 'A'),
(330, 'Shahdol', 20, 'A'),
(331, 'Shajapur', 20, 'A'),
(332, 'Sheopur', 20, 'A'),
(333, 'Shivpuri', 20, 'A'),
(334, 'Sidhi', 20, 'A'),
(335, 'Singrauli', 20, 'A'),
(336, 'Tikamgarh', 20, 'A'),
(337, 'Ujjain', 20, 'A'),
(338, 'Umaria', 20, 'A'),
(339, 'Vidisha', 20, 'A'),
(340, 'Ahmednagar', 21, 'A'),
(341, 'Akola', 21, 'A'),
(342, 'Amravati', 21, 'A'),
(343, 'Aurangabad', 21, 'A'),
(344, 'Beed', 21, 'A'),
(345, 'Bhandara', 21, 'A'),
(346, 'Buldhana', 21, 'A'),
(347, 'Chandrapur', 21, 'A'),
(348, 'Dhule', 21, 'A'),
(349, 'Gadchiroli', 21, 'A'),
(350, 'Gondia', 21, 'A'),
(351, 'Hingoli', 21, 'A'),
(352, 'Jalgaon', 21, 'A'),
(353, 'Jalna', 21, 'A'),
(354, 'Kolhapur', 21, 'A'),
(355, 'Latur', 21, 'A'),
(356, 'Mumbai City', 21, 'A'),
(357, 'Mumbai suburban', 21, 'A'),
(358, 'Nanded', 21, 'A'),
(359, 'Nandurbar', 21, 'A'),
(360, 'Nagpur', 21, 'A'),
(361, 'Nashik', 21, 'A'),
(362, 'Osmanabad', 21, 'A'),
(363, 'Parbhani', 21, 'A'),
(364, 'Pune', 21, 'A'),
(365, 'Raigad', 21, 'A'),
(366, 'Ratnagiri', 21, 'A'),
(367, 'Sangli', 21, 'A'),
(368, 'Satara', 21, 'A'),
(369, 'Sindhudurg', 21, 'A'),
(370, 'Solapur', 21, 'A'),
(371, 'Thane', 21, 'A'),
(372, 'Wardha', 21, 'A'),
(373, 'Washim', 21, 'A'),
(374, 'Yavatmal', 21, 'A'),
(375, 'Bishnupur', 22, 'A'),
(376, 'Churachandpur', 22, 'A'),
(377, 'Chandel', 22, 'A'),
(378, 'Imphal East', 22, 'A'),
(379, 'Senapati', 22, 'A'),
(380, 'Tamenglong', 22, 'A'),
(381, 'Thoubal', 22, 'A'),
(382, 'Ukhrul', 22, 'A'),
(383, 'Imphal West', 22, 'A'),
(384, 'East Garo Hills', 23, 'A'),
(385, 'East Khasi Hills', 23, 'A'),
(386, 'Jaintia Hills', 23, 'A'),
(387, 'Ri Bhoi', 23, 'A'),
(388, 'South Garo Hills', 23, 'A'),
(389, 'West Garo Hills', 23, 'A'),
(390, 'West Khasi Hills', 23, 'A'),
(391, 'Aizawl', 24, 'A'),
(392, 'Champhai', 24, 'A'),
(393, 'Kolasib', 24, 'A'),
(394, 'Lawngtlai', 24, 'A'),
(395, 'Lunglei', 24, 'A'),
(396, 'Mamit', 24, 'A'),
(397, 'Saiha', 24, 'A'),
(398, 'Serchhip', 24, 'A'),
(399, 'Dimapur', 25, 'A'),
(400, 'Kiphire', 25, 'A'),
(401, 'Kohima', 25, 'A'),
(402, 'Longleng', 25, 'A'),
(403, 'Mokokchung', 25, 'A'),
(404, 'Mon', 25, 'A'),
(405, 'Peren', 25, 'A'),
(406, 'Phek', 25, 'A'),
(407, 'Tuensang', 25, 'A'),
(408, 'Wokha', 25, 'A'),
(409, 'Zunheboto', 25, 'A'),
(410, 'Angul', 26, 'A'),
(411, 'Boudh (Bauda)', 26, 'A'),
(412, 'Bhadrak', 26, 'A'),
(413, 'Balangir', 26, 'A'),
(414, 'Bargarh (Baragarh)', 26, 'A'),
(415, 'Balasore', 26, 'A'),
(416, 'Cuttack', 26, 'A'),
(417, 'Debagarh (Deogarh)', 26, 'A'),
(418, 'Dhenkanal', 26, 'A'),
(419, 'Ganjam', 26, 'A'),
(420, 'Gajapati', 26, 'A'),
(421, 'Jharsuguda', 26, 'A'),
(422, 'Jajpur', 26, 'A'),
(423, 'Jagatsinghpur', 26, 'A'),
(424, 'Khordha', 26, 'A'),
(425, 'Kendujhar (Keonjhar)', 26, 'A'),
(426, 'Kalahandi', 26, 'A'),
(427, 'Kandhamal', 26, 'A'),
(428, 'Koraput', 26, 'A'),
(429, 'Kendrapara', 26, 'A'),
(430, 'Malkangiri', 26, 'A'),
(431, 'Mayurbhanj', 26, 'A'),
(432, 'Nabarangpur', 26, 'A'),
(433, 'Nuapada', 26, 'A'),
(434, 'Nayagarh', 26, 'A'),
(435, 'Puri', 26, 'A'),
(436, 'Rayagada', 26, 'A'),
(437, 'Sambalpur', 26, 'A'),
(438, 'Subarnapur (Sonepur)', 26, 'A'),
(439, 'Sundergarh', 26, 'A'),
(440, 'Karaikal', 27, 'A'),
(441, 'Mahe', 27, 'A'),
(442, 'Pondicherry', 27, 'A'),
(443, 'Yanam', 27, 'A'),
(444, 'Amritsar', 28, 'A'),
(445, 'Barnala', 28, 'A'),
(446, 'Bathinda', 28, 'A'),
(447, 'Firozpur', 28, 'A'),
(448, 'Faridkot', 28, 'A'),
(449, 'Fatehgarh Sahib', 28, 'A'),
(450, 'Fazilka[6]', 28, 'A'),
(451, 'Gurdaspur', 28, 'A'),
(452, 'Hoshiarpur', 28, 'A'),
(453, 'Jalandhar', 28, 'A'),
(454, 'Kapurthala', 28, 'A'),
(455, 'Ludhiana', 28, 'A'),
(456, 'Mansa', 28, 'A'),
(457, 'Moga', 28, 'A'),
(458, 'Sri Muktsar Sahib', 28, 'A'),
(459, 'Pathankot', 28, 'A'),
(460, 'Patiala', 28, 'A'),
(461, 'Rupnagar', 28, 'A'),
(462, 'Ajitgarh (Mohali)', 28, 'A'),
(463, 'Sangrur', 28, 'A'),
(464, 'Shahid Bhagat Singh Nagar', 28, 'A'),
(465, 'Tarn Taran', 28, 'A'),
(466, 'Ajmer', 29, 'A'),
(467, 'Alwar', 29, 'A'),
(468, 'Bikaner', 29, 'A'),
(469, 'Barmer', 29, 'A'),
(470, 'Banswara', 29, 'A'),
(471, 'Bharatpur', 29, 'A'),
(472, 'Baran', 29, 'A'),
(473, 'Bundi', 29, 'A'),
(474, 'Bhilwara', 29, 'A'),
(475, 'Churu', 29, 'A'),
(476, 'Chittorgarh', 29, 'A'),
(477, 'Dausa', 29, 'A'),
(478, 'Dholpur', 29, 'A'),
(479, 'Dungapur', 29, 'A'),
(480, 'Ganganagar', 29, 'A'),
(481, 'Hanumangarh', 29, 'A'),
(482, 'Jhunjhunu', 29, 'A'),
(483, 'Jalore', 29, 'A'),
(484, 'Jodhpur', 29, 'A'),
(485, 'Jaipur', 29, 'A'),
(486, 'Jaisalmer', 29, 'A'),
(487, 'Jhalawar', 29, 'A'),
(488, 'Karauli', 29, 'A'),
(489, 'Kota', 29, 'A'),
(490, 'Nagaur', 29, 'A'),
(491, 'Pali', 29, 'A'),
(492, 'Pratapgarh', 29, 'A'),
(493, 'Rajsamand', 29, 'A'),
(494, 'Sikar', 29, 'A'),
(495, 'Sawai Madhopur', 29, 'A'),
(496, 'Sirohi', 29, 'A'),
(497, 'Tonk', 29, 'A'),
(498, 'Udaipur', 29, 'A'),
(499, 'East Sikkim', 30, 'A'),
(500, 'North Sikkim', 30, 'A'),
(501, 'South Sikkim', 30, 'A'),
(502, 'West Sikkim', 30, 'A'),
(503, 'Ariyalur', 31, 'A'),
(504, 'Chennai', 31, 'A'),
(505, 'Coimbatore', 31, 'A'),
(506, 'Cuddalore', 31, 'A'),
(507, 'Dharmapuri', 31, 'A'),
(508, 'Dindigul', 31, 'A'),
(509, 'Erode', 31, 'A'),
(510, 'Kanchipuram', 31, 'A'),
(511, 'Kanyakumari', 31, 'A'),
(512, 'Karur', 31, 'A'),
(513, 'Krishnagiri', 31, 'A'),
(514, 'Madurai', 31, 'A'),
(515, 'Nagapattinam', 31, 'A'),
(516, 'Nilgiris', 31, 'A'),
(517, 'Namakkal', 31, 'A'),
(518, 'Perambalur', 31, 'A'),
(519, 'Pudukkottai', 31, 'A'),
(520, 'Ramanathapuram', 31, 'A'),
(521, 'Salem', 31, 'A'),
(522, 'Sivaganga', 31, 'A'),
(523, 'Tirupur', 31, 'A'),
(524, 'Tiruchirappalli', 31, 'A'),
(525, 'Theni', 31, 'A'),
(526, 'Tirunelveli', 31, 'A'),
(527, 'Thanjavur', 31, 'A'),
(528, 'Thoothukudi', 31, 'A'),
(529, 'Tiruvallur', 31, 'A'),
(530, 'Tiruvarur', 31, 'A'),
(531, 'Tiruvannamalai', 31, 'A'),
(532, 'Vellore', 31, 'A'),
(533, 'Viluppuram', 31, 'A'),
(534, 'Virudhunagar', 31, 'A'),
(535, 'Dhalai', 32, 'A'),
(536, 'North Tripura', 32, 'A'),
(537, 'South Tripura', 32, 'A'),
(538, 'Khowai[7]', 32, 'A'),
(539, 'West Tripura', 32, 'A'),
(540, 'Agra', 33, 'A'),
(541, 'Aligarh', 33, 'A'),
(542, 'Allahabad', 33, 'A'),
(543, 'Ambedkar Nagar', 33, 'A'),
(544, 'Auraiya', 33, 'A'),
(545, 'Azamgarh', 33, 'A'),
(546, 'Bagpat', 33, 'A'),
(547, 'Bahraich', 33, 'A'),
(548, 'Ballia', 33, 'A'),
(549, 'Balrampur', 33, 'A'),
(550, 'Banda', 33, 'A'),
(551, 'Barabanki', 33, 'A'),
(552, 'Bareilly', 33, 'A'),
(553, 'Basti', 33, 'A'),
(554, 'Bijnor', 33, 'A'),
(555, 'Budaun', 33, 'A'),
(556, 'Bulandshahr', 33, 'A'),
(557, 'Chandauli', 33, 'A'),
(558, 'Chhatrapati Shahuji Maharaj Nagar[8]', 33, 'A'),
(559, 'Chitrakoot', 33, 'A'),
(560, 'Deoria', 33, 'A'),
(561, 'Etah', 33, 'A'),
(562, 'Etawah', 33, 'A'),
(563, 'Faizabad', 33, 'A'),
(564, 'Farrukhabad', 33, 'A'),
(565, 'Fatehpur', 33, 'A'),
(566, 'Firozabad', 33, 'A'),
(567, 'Gautam Buddh Nagar', 33, 'A'),
(568, 'Ghaziabad', 33, 'A'),
(569, 'Ghazipur', 33, 'A'),
(570, 'Gonda', 33, 'A'),
(571, 'Gorakhpur', 33, 'A'),
(572, 'Hamirpur', 33, 'A'),
(573, 'Hardoi', 33, 'A'),
(574, 'Hathras', 33, 'A'),
(575, 'Jalaun', 33, 'A'),
(576, 'Jaunpur district', 33, 'A'),
(577, 'Jhansi', 33, 'A'),
(578, 'Jyotiba Phule Nagar', 33, 'A'),
(579, 'Kannauj', 33, 'A'),
(580, 'Kanpur', 33, 'A'),
(581, 'Kanshi Ram Nagar', 33, 'A'),
(582, 'Kaushambi', 33, 'A'),
(583, 'Kushinagar', 33, 'A'),
(584, 'Lakhimpur Kheri', 33, 'A'),
(585, 'Lalitpur', 33, 'A'),
(586, 'Lucknow', 33, 'A'),
(587, 'Maharajganj', 33, 'A'),
(588, 'Mahoba', 33, 'A'),
(589, 'Mainpuri', 33, 'A'),
(590, 'Mathura', 33, 'A'),
(591, 'Mau', 33, 'A'),
(592, 'Meerut', 33, 'A'),
(593, 'Mirzapur', 33, 'A'),
(594, 'Moradabad', 33, 'A'),
(595, 'Muzaffarnagar', 33, 'A'),
(596, 'Panchsheel Nagar district (Hapur)', 33, 'A'),
(597, 'Pilibhit', 33, 'A'),
(598, 'Pratapgarh', 33, 'A'),
(599, 'Raebareli', 33, 'A'),
(600, 'Ramabai Nagar (Kanpur Dehat)', 33, 'A'),
(601, 'Rampur', 33, 'A'),
(602, 'Saharanpur', 33, 'A'),
(603, 'Sant Kabir Nagar', 33, 'A'),
(604, 'Sant Ravidas Nagar', 33, 'A'),
(605, 'Shahjahanpur', 33, 'A'),
(606, 'Shamli[9]', 33, 'A'),
(607, 'Shravasti', 33, 'A'),
(608, 'Siddharthnagar', 33, 'A'),
(609, 'Sitapur', 33, 'A'),
(610, 'Sonbhadra', 33, 'A'),
(611, 'Sultanpur', 33, 'A'),
(612, 'Unnao', 33, 'A'),
(613, 'Varanasi', 33, 'A'),
(614, 'Almora', 34, 'A'),
(615, 'Bageshwar', 34, 'A'),
(616, 'Chamoli', 34, 'A'),
(617, 'Champawat', 34, 'A'),
(618, 'Dehradun', 34, 'A'),
(619, 'Haridwar', 34, 'A'),
(620, 'Nainital', 34, 'A'),
(621, 'Pauri Garhwal', 34, 'A'),
(622, 'Pithoragarh', 34, 'A'),
(623, 'Rudraprayag', 34, 'A'),
(624, 'Tehri Garhwal', 34, 'A'),
(625, 'Udham Singh Nagar', 34, 'A'),
(626, 'Uttarkashi', 34, 'A'),
(627, 'Bankura', 35, 'A'),
(628, 'Bardhaman', 35, 'A'),
(629, 'Birbhum', 35, 'A'),
(630, 'Cooch Behar', 35, 'A'),
(631, 'Dakshin Dinajpur', 35, 'A'),
(632, 'Darjeeling', 35, 'A'),
(633, 'Hooghly', 35, 'A'),
(634, 'Howrah', 35, 'A'),
(635, 'Jalpaiguri', 35, 'A'),
(636, 'Kolkata', 35, 'A'),
(637, 'Malda', 35, 'A'),
(638, 'Murshidabad', 35, 'A'),
(639, 'Nadia', 35, 'A'),
(640, 'North 24 Parganas', 35, 'A'),
(641, 'Paschim Medinipur', 35, 'A'),
(642, 'Purba Medinipur', 35, 'A'),
(643, 'Purulia', 35, 'A'),
(644, 'South 24 Parganas', 35, 'A'),
(645, 'Uttar Dinajpur', 35, 'A'),
(646, 'Balod', 7, 'A'),
(647, 'Baloda Bazar', 7, 'A'),
(648, 'Balrampur', 7, 'A'),
(650, 'Bemetara', 7, 'A'),
(651, 'Gariaband', 7, 'A'),
(652, 'Gaurela Pendra Marwahi', 7, 'A'),
(653, 'Kondagaon', 7, 'A'),
(654, 'Mungeli', 7, 'A'),
(655, 'Sukma', 7, 'A'),
(656, 'Surajpur', 7, 'A'),
(657, 'Shahdara', 10, 'A'),
(658, 'South East', 10, 'A'),
(660, 'Nellore', 2, 'D'),
(661, 'Majuli', 4, 'A'),
(662, 'Hojai', 4, 'A'),
(663, 'Adilabad', 37, 'A'),
(664, 'Bhadradri Kothagudem', 37, 'A'),
(665, 'Kothagudem', 37, 'D'),
(666, 'Hyderabad', 37, 'A'),
(667, 'Sangareddy', 37, 'A'),
(668, 'Siddipet', 37, 'A'),
(669, 'Suryapet', 37, 'A'),
(670, 'Vikarabad', 37, 'A'),
(672, 'Wanaparthy', 37, 'A'),
(673, 'Warangal (Rural)', 37, 'A'),
(674, 'Warangal (Urban)', 37, 'A'),
(675, 'Yadadri Bhuvanagiri', 37, 'A'),
(676, 'Bhuvanagiri', 37, 'D'),
(677, 'Jagtial', 37, 'A'),
(678, 'Jangaon', 37, 'A'),
(679, 'Jayashankar Bhupalpally', 37, 'A'),
(680, 'Bhoopalpally', 37, 'D'),
(681, 'Kamareddy', 37, 'A'),
(682, 'Jogulamba Gadwal', 37, 'A'),
(683, 'Karimnagar', 37, 'A'),
(684, 'Khammam', 37, 'A'),
(685, 'Kumuram Bheem', 37, 'A'),
(686, 'Asifabad', 37, 'D'),
(687, 'Mahabubabad', 37, 'A'),
(688, 'Mahabubnagar', 37, 'A'),
(689, 'Mancherial', 37, 'A'),
(690, 'Medak', 37, 'A'),
(691, 'Medchal', 37, 'A'),
(692, 'Nagarkurnool', 37, 'A'),
(693, 'Nalgonda', 37, 'A'),
(694, 'Nirmal', 37, 'A'),
(695, 'Nizamabad', 37, 'A'),
(696, 'Peddapalli', 37, 'A'),
(697, 'Rajanna Sircilla', 37, 'A'),
(698, 'Rangareddy', 37, 'A'),
(699, 'Mulugu', 37, 'A'),
(700, 'Narayanpet', 37, 'A'),
(701, 'Dharampur', 12, 'A'),
(702, 'Chhapra', 5, 'A'),
(703, 'Armoor', 37, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_education`
--

CREATE TABLE `master_education` (
  `EducationId` int(11) NOT NULL,
  `EducationName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EducationCode` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EducationType` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT 0,
  `Status` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_education`
--

INSERT INTO `master_education` (`EducationId`, `EducationName`, `EducationCode`, `EducationType`, `IsDeleted`, `Status`) VALUES
(1, 'Master of Computer Application', 'MCA', 'PostGraduation', 0, 'A'),
(2, 'Bachelor of Computer Application', 'BCA', 'Graduation', 0, 'A'),
(3, 'Bachelor of Engineering', 'BE', 'Graduation', 0, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_employee`
--

CREATE TABLE `master_employee` (
  `EmployeeID` int(11) NOT NULL,
  `EmpCode` int(11) NOT NULL,
  `EmpType` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'E',
  `EmpStatus` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'A-actve,D-delete,De-deactive',
  `Title` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Fname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `GradeId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `DesigId` int(11) NOT NULL DEFAULT 0,
  `RepEmployeeID` int(11) NOT NULL,
  `Contact` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Married` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DR` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Location` int(11) NOT NULL,
  `DOJ` date DEFAULT NULL,
  `DateOfSepration` date DEFAULT NULL,
  `CTC` decimal(10,0) NOT NULL,
  `LastUpdated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_employee`
--

INSERT INTO `master_employee` (`EmployeeID`, `EmpCode`, `EmpType`, `EmpStatus`, `Title`, `Fname`, `Sname`, `Lname`, `CompanyId`, `GradeId`, `DepartmentId`, `DesigId`, `RepEmployeeID`, `Contact`, `Email`, `Gender`, `Married`, `DR`, `Location`, `DOJ`, `DateOfSepration`, `CTC`, `LastUpdated`) VALUES
(1, 1, 'E', 'D', 'Mr.', 'JAIWANT', 'S', 'LAL', 1, 68, 10, 89, 51, '9329440331', 'jslal@vnrseeds.com', 'M', 'Y', 'N', 1, '2005-04-01', '2014-03-31', '413904', NULL),
(2, 5, 'E', 'A', 'Mr.', 'DINA', 'NATH', 'SINGH', 1, 71, 2, 240, 7, '9179042144', 'dinanath.singh@vnrseeds.com', 'M', 'Y', 'N', 9, '2005-04-01', NULL, '1400126', NULL),
(3, 8, 'E', 'D', 'Mr.', 'VISHWAJIT', 'KUMAR', '', 1, 8, 6, 67, 0, '0', '', 'M', 'N', 'N', 3, '2005-04-01', '2012-04-12', '516642', NULL),
(4, 11, 'E', 'A', 'Mr.', 'AKHILESH', 'KUMAR', 'SINGH', 1, 73, 6, 65, 140, '9305540330', 'akhilesh.singh@vnrseeds.com', 'M', 'Y', 'N', 5, '2005-04-01', NULL, '3339847', NULL),
(5, 12, 'E', 'A', 'Mr.', 'SACHIDANAND', 'KUMAR', '', 1, 68, 6, 67, 4, '7091458952', 'sachidanand.kumar@vnrseeds.com', 'M', 'Y', 'N', 199, '2005-04-01', NULL, '1247068', NULL),
(6, 14, 'E', 'A', 'Mr.', 'S', '', 'RUDRAPRAKASH', 1, 77, 4, 279, 224, '9380040330', 'rudy@vnrseeds.com', 'M', 'N', 'N', 6, '2005-07-01', NULL, '9200006', NULL),
(7, 17, 'E', 'A', 'Dr.', 'KRISHAN ', 'CHANDRA', 'UPADHYAY', 1, 77, 2, 278, 224, '8008261509', 'kc@vnrseeds.com', 'M', 'Y', 'Y', 7, '2005-12-03', NULL, '3882580', NULL),
(8, 19, 'E', 'D', 'Mr.', 'LALA', 'RAM', 'SAHU', 1, 62, 7, 97, 28, '9827190340', 'lalaram.vspl@gmail.com', 'M', 'Y', 'N', 1, '2005-12-01', '2021-01-07', '263995', NULL),
(9, 20, 'E', 'A', 'Mr.', 'CH', 'RAVI', 'KUMAR', 1, 63, 2, 131, 849, '9912596006', 'ravi.kumar@vnrseeds.com', 'M', 'Y', 'N', 7, '2005-12-10', NULL, '647203', NULL),
(10, 24, 'E', 'D', 'Mr.', 'PRAMOD', 'KUMAR', 'DUBEY', 1, 69, 2, 243, 7, '0', 'pramod.dubey@vnrseeds.com', 'M', 'Y', 'N', 75, '2006-03-17', NULL, '533032', NULL),
(11, 27, 'E', 'A', 'Mr.', 'GURMEET ', 'SINGH', 'NANDA', 1, 71, 6, 66, 140, '8295040330', 'gurmeet.nanda@vnrseeds.com', 'M', 'Y', 'N', 149, '2006-04-01', NULL, '1911592', NULL),
(12, 28, 'E', 'A', 'Mr.', 'DIGAMBER', '', 'DUTT', 1, 64, 2, 131, 1078, '9948907801', 'digamber.dutt@vnrseeds.com', 'M', 'Y', 'N', 7, '2006-06-01', NULL, '624122', NULL),
(13, 32, 'E', 'D', 'Mr.', 'ARUN', 'KUMAR', 'SAHU', 1, 67, 8, 378, 461, '9302840334', 'arun.sahu@vnrseeds.com', 'M', 'Y', 'N', 1, '2006-07-21', '2020-11-28', '917240', NULL),
(14, 36, 'E', 'A', 'Mr.', 'SACHIN', '', 'KUMAR', 1, 71, 6, 66, 241, '8347134444', 'sachin.kumar@vnrseeds.com', 'M', 'Y', 'N', 172, '2006-08-08', NULL, '2349756', NULL),
(15, 39, 'E', 'A', 'Mr.', 'SUDEEP', '', 'RANA', 1, 71, 3, 298, 719, '9981994833', 'sudeep.rana@vnrseeds.com', 'M', 'Y', 'N', 149, '2006-08-08', NULL, '1773776', NULL),
(16, 41, 'E', 'A', 'Mr.', 'BHUPENDRA', '', 'GAUTAM', 1, 67, 6, 415, 438, '9198120007', 'bhupendra.gautam@vnrseeds.com', 'M', 'Y', 'N', 12, '2006-12-01', NULL, '1291499', NULL),
(17, 42, 'E', 'D', 'Mr.', 'SHEKHAR', '', 'SAHA', 1, 63, 6, 254, 392, '9332040330', 'shekhar.saha@vnrseeds.com', 'M', 'Y', 'N', 143, '2006-12-01', '2015-12-31', '422990', NULL),
(18, 44, 'E', 'A', 'Mr.', 'SUDIP', '', 'DAS', 1, 65, 6, 255, 261, '9333440330', 'sudeep.das@vnrseeds.com', 'M', 'Y', 'N', 89, '2006-12-01', NULL, '820593', NULL),
(19, 45, 'E', 'A', 'Mr.', 'HARENDRA', '', 'KUMAR', 1, 67, 9, 325, 461, '9329040330', 'gautam.sharma@vnrseeds.com', 'M', 'Y', 'N', 1, '2007-02-01', NULL, '800006', NULL),
(20, 48, 'E', 'D', 'Mr.', 'ISHWARI', 'PRASAD', 'YADAV', 1, 66, 5, 463, 52, '7869998041', 'ishwari.yadav@vnrseeds.com', 'M', 'Y', 'N', 14, '2007-02-01', NULL, '676179', NULL),
(21, 50, 'E', 'A', 'Mr.', 'PARMESHWAR', '', 'NISHAD', 1, 0, 11, 113, 224, '9981995360', '', 'M', 'Y', 'N', 15, '2007-02-01', NULL, '342755', NULL),
(22, 51, 'E', 'D', 'Mr.', 'RAM', 'KUMAR', 'VISHWAKARMA', 1, 0, 11, 113, 224, '8717996200', '', 'M', 'Y', 'N', 15, '2007-02-01', '2020-06-09', '324458', NULL),
(23, 63, 'E', 'D', 'Mr.', 'DHIRAJ', '', 'PARMAR', 1, 68, 8, 81, 110, '9302817007', 'dhiraj.parmar@vnrseeds.com', 'M', 'Y', 'N', 1, '2007-04-19', '2014-03-31', '424300', NULL),
(24, 64, 'E', 'A', 'Mr.', 'ALOK', '', 'SINGH', 1, 68, 4, 156, 433, '9902135845', 'alok.singh@vnrseeds.com', 'M', 'Y', 'N', 84, '2007-04-20', NULL, '842579', NULL),
(25, 69, 'E', 'D', 'Mr.', 'KAPPA', 'SREENIVAS ', 'RAJU', 1, 67, 6, 415, 220, '9398340330', 'sreenivas.raju@vnrseeds.com', 'M', 'Y', 'N', 158, '2007-06-01', '2018-07-23', '945483', NULL),
(26, 75, 'E', 'A', 'Mr.', 'KHILESH', 'KUMAR', 'SAHU', 1, 63, 8, 193, 109, '7869898869', 'Khileshsahu1981@gmail.com', 'M', 'Y', 'N', 1, '2007-07-13', NULL, '378803', NULL),
(27, 81, 'E', 'A', 'Mr.', 'CHANDAN', 'LAL', 'SAHU', 1, 61, 7, 97, 28, '9009467151', 'lalsahuc@gmail.com', 'M', 'Y', 'N', 1, '2007-08-01', NULL, '234105', NULL),
(28, 85, 'E', 'A', 'Mr.', 'NANDKISHORE', '', 'SHARMA', 1, 72, 7, 345, 51, '9302847007', 'nandkishore.sharma@vnrseeds.com', 'M', 'Y', 'N', 1, '2007-08-06', NULL, '1628203', NULL),
(29, 87, 'E', 'A', 'Mr.', 'DUSHYANT', '', 'SAHU', 1, 68, 8, 378, 109, '9329654281', 'dushyant.sahu@vnrseeds.com', 'M', 'Y', 'N', 1, '2007-08-06', NULL, '900000', NULL),
(30, 89, 'E', 'D', 'Ms.', 'DEEPIKA', '', 'GAJJAR', 1, 65, 11, 106, 461, '0', 'deepika.gajjar@vnrseeds.com', 'F', 'N', 'N', 1, '2007-08-06', '2019-01-24', '453652', NULL),
(31, 90, 'E', 'D', 'Mr.', 'OM', ' PRAKASH', 'PATEL', 1, 66, 6, 68, 731, '9305996400', 'omprakash.patel@vnrseeds.com', 'M', 'Y', 'N', 18, '2007-08-13', '2019-05-19', '708091', NULL),
(32, 93, 'E', 'A', 'Mr.', 'AMARJEET', '', 'YADAV', 1, 66, 6, 68, 449, '9307080006', 'amarjeet.yadav@vnrseeds.com', 'M', 'Y', 'N', 145, '2007-08-13', NULL, '737609', NULL),
(33, 96, 'E', 'A', 'Mr.', 'AKSHYA', 'KUMAR', 'PADHAN', 1, 67, 6, 415, 375, '7682805992', 'akshay.pradhan@vnrseeds.com', 'M', 'Y', 'N', 20, '2007-09-01', NULL, '1169213', NULL),
(34, 97, 'E', 'A', 'Mr.', 'DINESH', '', 'SWAMI', 1, 72, 6, 65, 531, '9302340334', 'dinesh.swami@vnrseeds.com', 'M', 'Y', 'N', 21, '2007-10-01', NULL, '2479460', NULL),
(35, 101, 'E', 'A', 'Mr.', 'SURENDRA', '', 'KUMAR', 1, 74, 4, 366, 52, '8959590910', 'surendra.kumar@vnrseeds.com', 'M', 'Y', 'N', 22, '2007-11-01', NULL, '5758648', NULL),
(36, 105, 'E', 'D', 'Mrs.', 'SANGEETA', '', 'DOMINIC', 1, 65, 7, 208, 28, '0', 'sangeeta.sharma@vnrseeds.com', 'F', 'Y', 'N', 1, '2007-12-04', '2016-12-14', '322483', NULL),
(37, 106, 'E', 'D', 'Mr.', 'MAHESH', 'KUMAR', 'CHAUHAN', 1, 66, 6, 68, 438, '9307325806', 'mahesh.chauhan@vnrseeds.com', 'M', 'Y', 'N', 23, '2007-12-10', '2021-04-17', '992263', NULL),
(38, 111, 'E', 'D', 'Mr.', 'ABHINAY', 'KUMAR', 'JHA', 1, 4, 6, 69, 140, '0', '', 'M', 'N', 'N', 24, '2008-01-01', '2012-11-24', '242399', NULL),
(39, 112, 'E', 'A', 'Mr.', 'LOCHAN', 'KUMAR', 'GOHIL', 1, 69, 4, 373, 778, '9981995399', 'lochan.gohil@vnrseeds.in', 'M', 'Y', 'N', 272, '2008-01-01', NULL, '1444441', NULL),
(40, 114, 'E', 'D', 'Mr.', 'LAKHPATI', '', '', 1, 0, 5, 120, 52, '0', '', 'M', 'N', 'N', 14, '2008-01-18', '2014-12-03', '98058', NULL),
(41, 118, 'E', 'D', 'Mrs.', 'JAM BAI', '', 'NISHAD', 1, 0, 5, 120, 52, '0', '', 'F', 'Y', 'N', 14, '2008-01-18', '2017-04-01', '105654', NULL),
(42, 119, 'E', 'D', 'Mrs.', 'SANTOSHI', '', 'YADAV', 1, 0, 5, 120, 52, '0', '', 'F', 'Y', 'N', 14, '2008-01-18', '2017-04-01', '105654', NULL),
(43, 120, 'E', 'D', 'Mrs.', 'SOMLATA', '', '', 1, 0, 5, 120, 52, '0', '', 'F', 'Y', 'N', 14, '2008-01-18', '2017-01-31', '105654', NULL),
(44, 122, 'E', 'D', 'Mrs.', 'PADMA', '', '', 1, 0, 5, 120, 52, '0', '', 'F', 'Y', 'N', 14, '2008-01-18', '2017-04-01', '105654', NULL),
(45, 123, 'E', 'D', 'Mrs.', 'MANKI', '', '', 1, 0, 5, 120, 52, '0', '', 'F', 'Y', 'N', 14, '2008-01-18', '2017-04-01', '105654', NULL),
(46, 130, 'E', 'A', 'Mr.', 'MANOHAR', '', 'VERMA', 1, 67, 6, 415, 924, '9300340330', 'manohar.verma@vnrseeds.com', 'M', 'Y', 'N', 25, '2008-01-16', NULL, '936485', NULL),
(47, 132, 'E', 'D', 'Mr.', 'JITENDRA', '', 'KURREY', 1, 3, 4, 130, 39, '0', '', 'M', 'N', 'N', 91, '2008-02-19', '2013-01-07', '129085', NULL),
(48, 135, 'E', 'A', 'Mr.', 'JAGDISH', '', 'JAISWAL', 1, 62, 7, 188, 731, '9695781066', '', 'M', 'N', 'N', 4, '2008-01-01', NULL, '250007', NULL),
(49, 136, 'E', 'D', 'Mr.', 'ALOK', 'KUMAR', 'GUPTA', 1, 65, 7, 208, 4, '0', 'alok.kumar@vnrseeds.com', 'M', 'N', 'N', 95, '2008-01-01', '2018-05-07', '394738', NULL),
(50, 138, 'E', 'D', 'Mr.', 'GURVINDER', 'SINGH', 'BHULLAR', 1, 63, 6, 254, 11, '8427010330', 'gurvinder.singh@vnrseeds.com', 'M', 'Y', 'N', 119, '2008-02-05', '2015-04-23', '275578', NULL),
(51, 139, 'E', 'A', 'Mr.', 'ATUL', '', 'SAH', 1, 77, 6, 283, 224, '9630040330', 'atul.sah@vnrseeds.com', 'M', 'Y', 'N', 1, '2008-02-09', NULL, '18377754', NULL),
(52, 140, 'E', 'A', 'Mr.', 'RAJ', 'KUMAR', 'KUNDU', 1, 77, 5, 574, 6, '9302840331', 'rajkumar.kundu@vnrseeds.com', 'M', 'Y', 'N', 14, '2008-02-18', NULL, '8000007', NULL),
(53, 142, 'E', 'A', 'Mrs.', 'D. ROHINI', '', 'NARASAIYA', 1, 66, 8, 83, 109, '9425018823', 'd.rohini@vnrseeds.com', 'F', 'Y', 'N', 1, '2008-03-20', NULL, '586631', NULL),
(54, 144, 'E', 'A', 'Mr.', 'RAVINDRA', 'KUMAR', 'YADAV', 1, 66, 5, 464, 52, '8085158034', 'ravinder.yadav@vnrseeds.com', 'M', 'Y', 'N', 14, '2008-03-20', NULL, '795637', NULL),
(55, 147, 'E', 'D', 'Mr.', 'MITHILESH', 'KUMAR', '', 1, 7, 5, 49, 0, '0', '', 'M', 'N', 'N', 14, '2008-04-10', '2012-02-11', '0', NULL),
(56, 148, 'E', 'A', 'Mr.', 'PRAKASH', 'KUMAR', 'KAPRI', 1, 70, 5, 459, 52, '9390340330', 'pk.kapri@vnrseeds.com', 'M', 'Y', 'N', 155, '2008-04-10', NULL, '1457179', NULL),
(57, 149, 'E', 'D', 'Mr.', 'ABHAY', 'S', 'DHOK', 1, 70, 6, 66, 417, '9326840330', 'abhay.dhok@vnrseeds.com', 'M', 'Y', 'N', 28, '2008-04-01', '2016-08-31', '908827', NULL),
(58, 151, 'E', 'A', 'Mr.', 'ROOPAM', '', 'JOHRI', 1, 69, 1, 312, 142, '9302730007', 'roopam.johri@vnrseeds.com', 'M', 'Y', 'N', 1, '2008-05-08', NULL, '1096771', NULL),
(59, 152, 'E', 'A', 'Mr.', 'SHRAYES', '', 'GOTHI', 1, 65, 7, 208, 731, '9198210007', 'shrayes.gothi@vnrseeds.com', 'M', 'Y', 'N', 4, '2008-05-01', NULL, '479785', NULL),
(60, 156, 'E', 'D', 'Mr.', 'BRAJENDRA', 'KUMAR', 'MISHRA', 1, 8, 3, 149, 7, '9303040330', 'brajendra.mishra@vnrseeds.com', 'M', 'Y', 'N', 7, '2008-05-10', '2013-01-31', '585135', NULL),
(61, 157, 'E', 'A', 'Mr.', 'ANIL', 'KUMAR', 'SINGH', 1, 64, 6, 257, 261, '9305440330', 'anil.singh@vnrseeds.com', 'M', 'Y', 'N', 56, '2008-05-27', NULL, '506549', NULL),
(62, 158, 'E', 'D', 'Mr.', 'RAJENDRA', 'PRASAD', 'YADAV', 1, 69, 6, 67, 4, '9198360007', 'rajendra.yadav@vnrseeds.com', 'M', 'Y', 'N', 39, '2008-05-27', '2016-02-15', '866753', NULL),
(63, 159, 'E', 'D', 'Mr.', 'ANAND', 'KUMAR', 'MISHRA', 1, 4, 6, 69, 0, '0', '', 'M', 'N', 'N', 31, '2008-06-02', '2012-10-10', '0', NULL),
(64, 162, 'E', 'A', 'Mr.', 'NAVIN', '', 'AGRAWAL', 1, 66, 9, 201, 461, '9300877377', 'navin.agrawal@vnrseeds.com', 'M', 'Y', 'N', 1, '2008-06-23', NULL, '650471', NULL),
(65, 163, 'E', 'A', 'Mr.', 'ASHOK', 'KUMAR', 'PATEL', 1, 74, 2, 244, 7, '9300040330', 'ashok.patel@vnrseeds.com', 'M', 'Y', 'N', 1, '2008-06-25', NULL, '5170555', NULL),
(66, 164, 'E', 'A', 'Mr.', 'SEVAK', 'RAM', 'VERMA', 1, 72, 2, 1, 89, '8978873410', 'sevak.verma@vnrseeds.com', 'M', 'Y', 'N', 7, '2008-07-01', NULL, '1812973', NULL),
(67, 166, 'E', 'A', 'Mr.', 'CHANDRAKANT', '', 'SINGH ', 1, 66, 4, 373, 845, '9993926951', 'Chandrakantsinghrajput539@gmail.com', 'M', 'Y', 'N', 118, '2008-07-01', NULL, '480473', NULL),
(68, 167, 'E', 'D', 'Mr.', 'BHIMRAO', '', 'GAYAKWAD', 1, 63, 4, 226, 279, '0', '', 'M', 'Y', 'N', 66, '2008-07-01', '2015-01-27', '156102', NULL),
(69, 171, 'E', 'A', 'Mr.', 'PATHAKALA', '', 'SHANKAR', 1, 65, 4, 306, 820, '9618177270', 'p.pshankar@vnrseeds.com', 'M', 'Y', 'N', 22, '2008-07-21', NULL, '577982', NULL),
(70, 175, 'E', 'A', 'Mr.', 'MUDUGUNT', 'RAMA KRISHNA', 'REDDY', 1, 65, 4, 306, 359, '9866808471', 'mrkreddy7077@gmail.com', 'M', 'Y', 'N', 22, '2008-07-21', NULL, '569847', NULL),
(71, 180, 'E', 'D', 'Mr.', 'GANDLA', 'PANDU', '', 1, 61, 4, 225, 35, '0', '', 'M', 'Y', 'N', 22, '2008-07-21', '2014-08-26', '131022', NULL),
(72, 184, 'E', 'A', 'Mr.', 'NARESH', 'KUMAR', '', 1, 65, 5, 462, 52, '7999408628', 'naresh@vnrseeds.com', 'M', 'Y', 'N', 14, '2008-07-31', NULL, '479465', NULL),
(73, 187, 'E', 'A', 'Mr.', 'ACHCHEYLAL', '', 'CHAUHAN', 1, 71, 4, 370, 433, '9427279330', 'achchheylal.chauhan@vnrseeds.com', 'M', 'Y', 'N', 90, '2008-08-21', NULL, '1814275', NULL),
(74, 188, 'E', 'D', 'Mr.', 'ROBIN', '', 'SINGH', 1, 68, 4, 156, 35, '0', 'robin.singh@vnrseeds.com', 'M', 'Y', 'N', 22, '2008-08-25', '2014-10-15', '795908', NULL),
(75, 189, 'E', 'D', 'Mr.', 'RAJESH', 'KUMAR', 'SINGH', 1, 7, 4, 29, 35, '0', '', 'M', 'N', 'N', 22, '2008-08-28', '2012-12-01', '442646', NULL),
(76, 190, 'E', 'A', 'Mr.', 'UMESHWER', 'RAO', 'MANDA', 1, 64, 4, 306, 820, '8790101732', 'umeshwarmanda@gmail.com', 'M', 'Y', 'N', 22, '2008-09-01', NULL, '335435', NULL),
(77, 191, 'E', 'A', 'Mr.', 'ARUNENDRA', 'PRATAP', 'SINGH', 1, 66, 10, 204, 662, '9179042136', 'arunendrapratap.singh@vnrseeds.com', 'M', 'Y', 'N', 1, '2008-09-18', NULL, '565425', NULL),
(78, 193, 'E', 'D', 'Mr.', 'D CHANDRA', 'SEKHARA', 'REDDY', 1, 66, 6, 68, 597, '9393440330', 'dcs.reddy@vnrseeds.com', 'M', 'Y', 'N', 32, '2008-09-24', '2019-04-17', '931061', NULL),
(79, 11001, 'E', 'D', 'Mr.', 'TAMATAM ', '', 'RAVINDRA ', 1, 72, 6, 375, 531, '9396340330', 'tamatam.ravinder@vnrseeds.com', 'M', 'Y', 'N', 7, '2008-10-10', '2018-06-30', '1803227', NULL),
(80, 197, 'E', 'A', 'Mr.', 'SHIV ', '', 'PRAKASH', 1, 66, 6, 68, 4, '9934846450', 'shiv.prakash@vnrseeds.com', 'M', 'Y', 'N', 33, '2008-10-11', NULL, '832430', NULL),
(81, 200, 'E', 'A', 'Mr.', 'SUNIL', 'VASUDEV', 'KALASKAR', 1, 66, 5, 467, 56, '9848692103', 'sunil.kalaskar@vnrseeds.com', 'M', 'Y', 'N', 155, '2008-10-10', NULL, '567439', NULL),
(82, 204, 'E', 'D', 'Mr.', 'BISHNU', 'CHARAN', 'SAMANTHRAY', 1, 66, 6, 68, 375, '0', 'bishnu.charan@vnrseeds.com', 'M', 'Y', 'N', 34, '2008-11-05', '2015-04-03', '511694', NULL),
(83, 205, 'E', 'A', 'Mr.', 'KRISHNA', '', 'DAHARIYA', 1, 64, 1, 301, 58, '8720837504', 'krishna.dahariya@vnrseeds.com', 'M', 'N', 'N', 1, '2008-11-01', NULL, '321671', NULL),
(84, 208, 'E', 'A', 'Mr.', 'RAHUL', '', 'TRIPATHI', 1, 67, 6, 485, 224, '9981995388', 'rahul.tripathi@vnrseeds.com', 'M', 'Y', 'N', 15, '2008-12-01', NULL, '958101', NULL),
(85, 212, 'E', 'A', 'Mr.', 'VINEET', 'KUMAR', 'SHAKYA', 1, 66, 6, 68, 438, '9198130007', 'vineet.shakya@vnrseeds.com', 'M', 'Y', 'N', 2, '2008-12-09', NULL, '670453', NULL),
(86, 213, 'E', 'A', 'Mr.', 'RAVINDRA', 'SINGH', 'SOLANKI', 1, 67, 6, 415, 550, '9314901330', 'ravindra.solanki@vnrseeds.com', 'M', 'Y', 'N', 37, '2008-12-23', NULL, '1206423', NULL),
(87, 214, 'E', 'A', 'Mr.', 'GYAN CHAND', '', 'TRIPATHI', 1, 64, 6, 257, 946, '9838312760', 'gyan.chandra@vnrseeds.com', 'M', 'Y', 'N', 209, '2008-12-09', NULL, '491250', NULL),
(88, 215, 'E', 'A', 'Mr.', 'SUSHIL', 'KUMAR', 'SAHU', 1, 66, 7, 208, 28, '9301177007', 'sushil.sahu@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-01-01', NULL, '579182', NULL),
(89, 216, 'E', 'A', 'Mr.', 'PARAG', '', 'AGARWAL', 1, 77, 2, 280, 224, '9573678382', 'parag.agarwal@vnrseeds.com', 'M', 'Y', 'N', 7, '2009-01-12', NULL, '11500001', NULL),
(90, 217, 'E', 'D', 'Mr.', 'PAWAN', '', 'RATHOD', 1, 2, 6, 70, 34, '0', 'pawan.rathore@vnrseeds.com', 'M', 'Y', 'N', 38, '2009-01-14', '2013-09-13', '172408', NULL),
(91, 218, 'E', 'D', 'Mr.', 'VANNAL', 'KANHAIYYA', 'BABULAL', 1, 0, 0, 0, 0, '0', '', 'M', 'N', 'N', 0, NULL, NULL, '0', NULL),
(92, 219, 'E', 'D', 'Mr.', 'SATYENDRA', 'KUMAR', 'SINGH', 1, 2, 6, 70, 15, '9307079790', 'sateyendra.singh@vnrseeds.com', 'M', 'Y', 'N', 39, '2009-01-19', '2013-11-15', '156234', NULL),
(93, 220, 'E', 'A', 'Mr.', 'SOURABH', '', 'PARSAI', 1, 65, 8, 83, 109, '9893907883', 'sourabh.parsai@vnrseeds.com', 'M', 'N', 'N', 1, '2009-02-02', NULL, '448474', NULL),
(94, 222, 'E', 'D', 'Mr.', 'M.PONSELVARAM', '', '', 1, 66, 6, 68, 370, '9790257670', 'ponselva.ram@vnrseeds.com', 'M', 'Y', 'N', 200, '2009-02-02', '2021-07-09', '691638', NULL),
(95, 226, 'E', 'D', 'Mr.', 'LABHOO', 'RAM', 'KASHYAP', 1, 70, 6, 66, 51, '9376940330', 'labhoo.kashyap@vnrseeds.com', 'M', 'Y', 'N', 42, '2009-03-06', '2014-09-09', '964166', NULL),
(96, 227, 'E', 'A', 'Mr.', 'MOHD. ', '', 'SHAFI', 1, 66, 6, 68, 11, '8427857130', 'mohd.shafi@vnrseeds.com', 'M', 'Y', 'N', 41, '2009-03-02', NULL, '660791', NULL),
(97, 228, 'E', 'A', 'Mr.', 'PRADEEP', '', 'TIWARI', 1, 73, 12, 469, 51, '9303640338', 'pradeep.tiwari@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-03-21', NULL, '4255943', NULL),
(98, 229, 'E', 'A', 'Mr.', 'GAUTAM', '', 'CHANDRAKAR', 1, 66, 7, 208, 28, '9617309080', 'gautam.chandrakar@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-03-16', NULL, '717059', NULL),
(99, 230, 'E', 'A', 'Mr.', 'RINESH', '', 'KUMAR', 1, 67, 6, 415, 11, '8295011330', 'rinesh.kumar@vnrseeds.com', 'M', 'Y', 'N', 43, '2009-04-01', NULL, '948941', NULL),
(100, 231, 'E', 'D', 'Mr.', 'SANTOSH', '', 'LUKHEY', 1, 65, 7, 208, 28, '9755033777', 'santosh.lukhey@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-04-06', '2021-05-03', '540072', NULL),
(101, 232, 'E', 'D', 'Mr.', 'VINOD', 'KUMAR', 'YADAV', 1, 9, 9, 86, 223, '0', 'vinod.yadav@vnrseeds.in', 'M', 'Y', 'N', 1, '2009-04-07', '2013-10-31', '363146', NULL),
(102, 233, 'E', 'A', 'Mr.', 'ANAND', '', 'KUSRE', 1, 64, 7, 207, 28, '9826116759', 'anand.kusre@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-04-07', NULL, '429500', NULL),
(103, 236, 'E', 'D', 'Mr.', 'RAKESH', '', 'CHANDRA', 1, 65, 6, 255, 399, '9359282330', 'rakesh.chandra@vnrseeds.com', 'M', 'Y', 'N', 148, '2009-05-04', '2016-07-02', '398681', NULL),
(104, 237, 'E', 'D', 'Mr.', 'INDRAJEET', '', 'YADAV', 1, 63, 6, 254, 250, '9369850330', 'indrajeet.yadav@vnrseeds.com', 'M', 'Y', 'N', 45, '2009-05-09', '2014-04-08', '242008', NULL),
(105, 238, 'E', 'D', 'Mr.', 'POSHAN', 'SINGH', 'RAJPUT', 1, 4, 5, 121, 52, '0', 'poshan.singh@vnrseeds.com', 'M', 'Y', 'N', 14, '2009-05-20', '2013-06-15', '197498', NULL),
(106, 239, 'E', 'D', 'Mr.', 'RAJBEER', '', 'SINGH', 1, 69, 6, 67, 34, '9372780330', 'rajbeer.singh@vnrseeds.com', 'M', 'N', 'N', 172, '2009-05-22', '2016-09-10', '907848', NULL),
(107, 240, 'E', 'D', 'Mr.', 'RAMESHWER', 'SINGH', 'SOLANKI', 1, 66, 6, 68, 438, '9198140007', 'rameshwar.singh@vnrseeds.com', 'M', 'Y', 'N', 47, '2009-05-22', '2017-06-02', '711631', NULL),
(108, 241, 'E', 'A', 'Mr.', 'AKHILESH', 'KUMAR', 'SINGH', 1, 72, 2, 1, 7, '8099036178', 'akhilesh.kumar@vnrseeds.com', 'M', 'Y', 'N', 7, '2009-05-21', NULL, '2360927', NULL),
(109, 244, 'E', 'A', 'Mr.', 'MANISH', '', 'KARKUN', 1, 73, 8, 284, 110, '9685436177', 'manish.karkun@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-06-02', NULL, '2044523', NULL),
(110, 245, 'E', 'A', 'Mr.', 'ASHISH', '', 'BAJPAI', 1, 74, 8, 79, 461, '9301260007', 'gm.finance@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-06-02', NULL, '4133523', NULL),
(111, 246, 'E', 'D', 'Mr.', 'NEERAJ', '', 'BABU', 1, 66, 4, 223, 35, '0', 'neeraj.babu@vnrseeds.in', 'M', 'Y', 'N', 22, '2009-06-16', '2014-07-04', '353117', NULL),
(112, 247, 'E', 'D', 'Mr.', 'ARUN', '', 'KUMAR', 1, 66, 25, 196, 195, '0', 'arun.kumar@vnrseeds.in', 'M', 'Y', 'N', 9, '2009-06-18', '2014-11-27', '375359', NULL),
(113, 248, 'E', 'D', 'Mr.', 'VINOD', '', 'KUMAR', 1, 66, 4, 223, 121, '9589700581', 'vinod.kumar@vnrseeds.in', 'M', 'Y', 'N', 118, '2009-06-25', '2014-08-18', '360211', NULL),
(114, 249, 'E', 'A', 'Mr.', 'JOYDEEP', 'DEY', '', 1, 65, 6, 255, 916, '9435564418', 'joydeep.dey@vnrseeds.com', 'M', 'N', 'N', 197, '2009-07-02', NULL, '567057', NULL),
(115, 250, 'E', 'D', 'Mr.', 'KALPESH', 'BHIKHA BHAI', 'VASOYA', 1, 66, 6, 68, 14, '9375640330', 'kalpeshb.vasoya@vnrseeds.com', 'M', 'Y', 'N', 123, '2009-07-16', '2015-04-04', '410953', NULL),
(116, 251, 'E', 'A', 'Mr.', 'JAIPRAKASH', '', 'YADAV', 1, 66, 7, 208, 28, '8103374211', 'jaiprakash.yadav@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-07-01', NULL, '575157', NULL),
(117, 253, 'E', 'D', 'Mr.', 'GOSWAMI', 'SAMEER', 'KANTIBHARTI', 1, 64, 6, 257, 14, '9376440330', 'goswami.sameer@vnrseeds.com', 'M', 'Y', 'N', 52, '2009-07-27', '2015-04-11', '273280', NULL),
(118, 255, 'E', 'D', 'Mr.', 'SURENDRA', 'SINGH', 'CHAUHAN', 1, 64, 8, 193, 13, '9981995382', 'surendra.chauhan@vnrseeds.in', 'M', 'Y', 'N', 1, '2009-10-01', '2014-08-19', '231838', NULL),
(119, 256, 'E', 'D', 'Mr.', 'MADALA', '', 'SREENIVASULU', 1, 63, 6, 254, 79, '9392640330', 'madala.sreenivasulu@vnrseeds.com', 'M', 'N', 'N', 53, '2009-10-01', '2017-02-04', '238102', NULL),
(120, 257, 'E', 'A', 'Mr.', 'BHUSHAN ', 'HARINARAYAN', 'KHARKAR', 1, 69, 40, 572, 65, '9713116899', 'bhushanh.kharkar@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-10-08', NULL, '1105472', NULL),
(121, 258, 'E', 'D', 'Mr.', 'SANJAY', '', 'JAYASWAL', 1, 69, 4, 371, 35, '9630079190', 'sanjay.jayswal@vnrseeds.com', 'M', 'Y', 'N', 118, '2009-10-10', '2019-10-29', '1031975', NULL),
(122, 259, 'E', 'A', 'Mr.', 'K.VENKATESH', '', '', 1, 64, 4, 306, 359, '9490296914', 'venkateshkadarla.vk@gmail.com', 'M', 'Y', 'N', 22, '2009-10-12', NULL, '405636', NULL),
(123, 260, 'E', 'D', 'Mr.', 'POTHRAJU', '', 'VITTAL', 1, 65, 4, 306, 821, '9866340661', 'pothvittal@gmail.com', 'M', 'Y', 'N', 22, '2009-10-12', '2020-10-25', '397391', NULL),
(124, 264, 'E', 'D', 'Mr.', 'ALMASPUR', '', 'BHASKAR', 1, 0, 0, 0, 0, '0', '', 'M', 'N', 'N', 0, NULL, NULL, '0', NULL),
(125, 266, 'E', 'D', 'Mr.', 'VISHNUKANTH M', '', 'BENNUR', 1, 3, 6, 70, 79, '0', '', 'M', 'N', 'N', 54, '2009-12-01', '2012-12-31', '270527', NULL),
(126, 270, 'E', 'A', 'Mr.', 'SUNIL', '', 'KUMAR', 1, 66, 6, 68, 11, '8295511330', 'sunil.kumar@vnrseeds.com', 'M', 'Y', 'N', 55, '2009-12-23', NULL, '797135', NULL),
(127, 11002, 'E', 'D', 'Mr.', 'DWARIKA', '', 'MAHTO', 1, 63, 6, 254, 261, '9755531400', 'dwarikavnr2009@gmail.com', 'M', 'Y', 'N', 56, '2010-01-02', '2019-01-23', '351338', NULL),
(128, 274, 'E', 'A', 'Mr.', 'DEVIDAS', 'RAMDAS', 'CHIKATE', 1, 64, 6, 257, 913, '9561324447', 'devidas.chikate@vnrseeds.com', 'M', 'Y', 'N', 57, '2010-01-14', NULL, '536730', NULL),
(129, 275, 'E', 'D', 'Mr.', 'K SURENDER', '', '', 1, 63, 2, 131, 108, '0', 'k.surendra@vnrseeds.com', 'M', 'Y', 'N', 7, '2010-01-16', '2018-09-30', '433036', NULL),
(130, 276, 'E', 'D', 'Mr.', 'SIDHAYYA', 'BAMMAYYA', 'SWAMI', 1, 3, 6, 70, 0, '0', '', 'M', 'N', 'N', 58, '2010-01-19', '2012-10-07', '0', NULL),
(131, 277, 'E', 'A', 'Mr.', 'AMITOSH', '', 'SINGH', 1, 66, 6, 68, 924, '9109084098', 'amitosh.singh@vnrseeds.com', 'M', 'Y', 'N', 107, '2010-02-01', NULL, '706910', NULL),
(132, 278, 'E', 'D', 'Mr.', 'SESHIREDDY', 'LAKKI', 'REDDY', 1, 64, 8, 193, 89, '0', 'seshi.reddy@vnrseeds.com', 'M', 'Y', 'N', 7, '2010-02-01', '2016-09-27', '363585', NULL),
(133, 279, 'E', 'A', 'Mr.', 'MAHENDRA', 'SINGH', 'RAJPUT', 1, 64, 2, 131, 692, '9652011586', '', 'M', 'Y', 'N', 226, '2010-02-01', NULL, '608586', NULL),
(134, 280, 'E', 'A', 'Mr.', 'RAVINDRA', '', 'AGRAWAL', 1, 63, 7, 207, 28, '9039198735', 'ravindra.agrawal@vnrseeds.com', 'M', 'Y', 'N', 1, '2010-02-01', NULL, '374303', NULL),
(135, 281, 'E', 'D', 'Mr.', 'DINESH', 'KUMAR LALSINH', 'SOLANKI', 1, 63, 4, 226, 73, '9727126210', '', 'M', 'Y', 'N', 90, '2010-02-01', '2016-10-22', '230051', NULL),
(136, 283, 'E', 'D', 'Mr.', 'PATEL', 'HARSHAD KUMAR', 'ASHOK BHAI', 1, 64, 6, 257, 14, '9328340330', 'patel.harshad@vnrseeds.com', 'M', 'Y', 'N', 60, '2010-02-19', '2015-07-21', '297476', NULL),
(137, 285, 'E', 'D', 'Mr.', 'M RAMESH ', '', '', 1, 64, 4, 222, 35, '0', '', 'M', 'Y', 'N', 22, '2010-03-02', '2015-01-12', '238440', NULL),
(138, 286, 'E', 'D', 'Mr.', 'T. NARSIMLU', '', '', 1, 1, 4, 132, 0, '0', '', 'M', 'N', 'N', 22, '2010-03-02', '2012-12-07', '0', NULL),
(139, 287, 'E', 'D', 'Mrs.', 'G RUPA ', '', '', 1, 63, 5, 127, 52, '0', 'g.rupa@vnrseeds.com', 'F', 'Y', 'N', 14, '2010-03-02', '2016-03-30', '226917', NULL),
(140, 288, 'E', 'A', 'Mr.', 'HITENDRA', '', 'SINGH', 1, 75, 6, 63, 51, '9303540553', 'hitendra.singh@vnrseeds.com', 'M', 'Y', 'N', 1, '2010-03-19', NULL, '7483668', NULL),
(141, 289, 'E', 'D', 'Mr.', 'RAJ', '', 'NIRMALKAR', 1, 64, 8, 193, 110, '0', 'raj.nirmalkar@vnrseeds.com', 'M', 'Y', 'N', 1, '2010-04-01', '2015-09-06', '283521', NULL),
(142, 291, 'E', 'A', 'Dr.', 'PARUL', '', 'PARMAR', 1, 74, 1, 281, 461, '9300125137', 'parul.parmar@vnrseeds.com', 'F', 'Y', 'Y', 1, '2010-04-30', NULL, '3871034', NULL),
(143, 294, 'E', 'A', 'Mr.', 'LALIT', 'MOHAN', '', 1, 69, 3, 604, 719, '9893532707', 'lalit.mohan@vnrseeds.com', 'M', 'Y', 'N', 38, '2010-06-01', NULL, '1444281', NULL),
(144, 296, 'E', 'D', 'Mr.', 'RAJAN', 'KUMAR', 'VISHWAKARMA', 1, 64, 5, 395, 52, '0', 'rajan.sharma@vnrseeds.com', 'M', 'Y', 'N', 14, '2010-06-21', '2016-04-15', '462046', NULL),
(145, 297, 'E', 'A', 'Mr.', 'ASHUTOSH', '', 'VERMA', 1, 70, 4, 371, 362, '9494857755', 'ashutosh.verma@vnrseeds.com', 'M', 'Y', 'N', 22, '2010-07-02', NULL, '1365629', NULL),
(146, 298, 'E', 'D', 'Mr.', 'BABASAHEB', 'NARAYAN', 'SHELKE', 1, 63, 6, 254, 106, '9326340330', 'bn.shelke@vnrseeds.com', 'M', 'Y', 'N', 61, '2010-07-05', '2015-07-06', '357673', NULL),
(147, 299, 'E', 'D', 'Dr.', 'SACHIN', 'SINGH', 'JAGWAN', 1, 7, 2, 5, 108, '0', 'sachin.jagwan@vnrseeds.com', 'M', 'Y', 'Y', 7, '2010-07-07', '2013-06-29', '309581', NULL),
(148, 300, 'E', 'D', 'Mr.', 'PRAVEEN', 'KUMAR', '', 1, 65, 3, 213, 600, '9506602261', 'praveen.kumar@vnrseeds.com', 'M', 'Y', 'N', 205, '2010-07-08', '2018-07-20', '430592', NULL),
(149, 301, 'E', 'A', 'Mr.', 'KOLAKANI ', '', 'RAMESH', 1, 66, 4, 598, 35, '9533181509', 'kolakani.ramesh@vnrseeds.com', 'M', 'Y', 'N', 22, '2010-07-01', NULL, '546487', NULL),
(150, 302, 'E', 'A', 'Mr.', 'KOMAL ', 'SINGH', 'PAL', 1, 64, 2, 131, 179, '9573483840', 'kp.singh@vnrseeds.com', 'M', 'Y', 'N', 7, '2010-07-01', NULL, '595579', NULL),
(151, 303, 'E', 'D', 'Mr.', 'AMIT', 'KUMAR', 'SAHOO', 1, 63, 6, 254, 308, '0', 'amit.sahoo@vnrseeds.com', 'M', 'Y', 'N', 62, '2010-08-23', '2014-11-05', '187902', NULL),
(152, 307, 'E', 'D', 'Mr.', 'RAKESH', 'KUMAR', '', 1, 2, 5, 124, 0, '0', '', 'M', 'N', 'N', 14, '2010-09-09', '2012-09-27', '0', NULL),
(153, 308, 'E', 'A', 'Mr.', 'HARISH', 'CHANDRA', 'SAHU', 1, 66, 6, 68, 252, '7000727609', 'harish.chandra@vnrseeds.com', 'M', 'Y', 'N', 260, '2010-09-10', NULL, '774904', NULL),
(154, 310, 'E', 'D', 'Mr.', 'ARVIND', 'KUMAR', 'SAHU', 1, 63, 6, 254, 308, '9303305330', 'ak.sahu@vnrseeds.com', 'M', 'Y', 'N', 64, '2010-10-01', '2015-08-12', '239088', NULL),
(155, 311, 'E', 'D', 'Mr.', 'SUNIL', 'KUMAR', 'YADAV', 1, 0, 0, 0, 0, '0', '', 'M', 'N', 'N', 0, NULL, NULL, '0', NULL),
(156, 312, 'E', 'D', 'Mr.', 'DHARMBIR', '', 'TIWARI', 1, 66, 6, 68, 449, '9547547153', 'dharmbir.tiwari@vnrseeds.com', 'M', 'Y', 'N', 65, '2010-10-14', '2018-12-05', '675472', NULL),
(157, 313, 'E', 'D', 'Mr.', 'MANGALA', 'PRASAD', 'AWASTHI', 1, 67, 6, 415, 252, '7697700330', 'mangala.awasthi@vnrseeds.com', 'M', 'Y', 'N', 66, '2010-10-14', '2018-05-10', '979240', NULL),
(158, 314, 'E', 'D', 'Mr.', 'MRITUNJAY', 'PRATAP', 'SHAHI', 1, 2, 6, 70, 241, '0', 'mritunjayp.shahi@vnrseeds.com', 'M', 'Y', 'N', 67, '2010-10-20', '2013-09-25', '165085', NULL),
(159, 315, 'E', 'D', 'Mr.', 'CHAPARTHI ', 'KISHORE', 'KUMAR', 1, 65, 6, 255, 220, '9390640330', 'chkishore.kumar@vnrseeds.com', 'M', 'Y', 'N', 68, '2010-12-01', '2017-11-03', '391894', NULL),
(160, 316, 'E', 'D', 'Mr.', 'E.BRAHMANANDA', 'REDDY', '', 1, 2, 6, 70, 0, '9390440330', 'e.brahmananda@vnrseeds.com', 'M', 'N', 'N', 7, '2010-12-01', '2012-12-28', '208537', NULL),
(161, 317, 'E', 'A', 'Mr.', 'VIPIN', 'KUMAR', 'SHARMA', 1, 64, 11, 190, 58, '9301731716', 'vipin.sharma@vnrseeds.in', 'M', 'Y', 'N', 1, '2010-12-06', NULL, '300011', NULL),
(162, 319, 'E', 'D', 'Mr.', 'ADINARAYANA', '', 'MALLELA', 1, 63, 6, 254, 79, '9347740330', 'm.adinarayana@vnrseeds.com', 'M', 'Y', 'N', 69, '2010-12-09', '2017-02-04', '202264', NULL),
(163, 321, 'E', 'D', 'Mr.', 'THAKOR  ', 'MANHAR BHAI', ' JALAM BHAI', 1, 65, 4, 306, 73, '9428770110', '', 'M', 'Y', 'N', 90, '2011-01-03', '2019-05-19', '337898', NULL),
(164, 322, 'E', 'D', 'Mr.', 'BARIYA', ' BABU ', 'BHAI', 1, 1, 4, 132, 73, '0', '', 'M', 'Y', 'N', 90, '2011-01-03', '2013-10-19', '117085', NULL),
(165, 323, 'E', 'A', 'Mr.', 'DAMAR', '', ' SINGH ', 1, 63, 2, 21, 65, '8966849227', '', 'M', 'Y', 'N', 1, '2011-01-07', NULL, '437439', NULL),
(166, 324, 'E', 'D', 'Mr.', 'AJIT ', 'KUMAR', '', 1, 66, 2, 6, 65, '9131598028', 'ajitk.kurrey@vnrseeds.com', 'M', 'Y', 'N', 1, '2011-01-07', '2020-11-05', '428495', NULL),
(167, 327, 'E', 'D', 'Mr.', 'SAMEER A', '', 'SHELAR', 1, 65, 6, 255, 431, '9370840330', 'sameer.a@vnrseeds.com', 'M', 'Y', 'N', 46, '2011-02-01', '2016-09-30', '444654', NULL),
(168, 328, 'E', 'A', 'Mr.', 'ABHISHEK', '', 'PANDEY', 1, 67, 6, 415, 449, '9305996700', 'abhishek.pandey@vnrseeds.com', 'M', 'Y', 'N', 18, '2011-02-10', NULL, '1062041', NULL),
(169, 329, 'E', 'A', 'Mr.', 'AJAY', 'KUMAR', 'DEWANGAN', 1, 67, 9, 324, 461, '8602190312', 'ajaykumar.dewangan@vnrseeds.in', 'M', 'Y', 'N', 1, '2011-02-11', NULL, '805099', NULL),
(170, 331, 'E', 'D', 'Mr.', 'SANJU', 'KUMAR', 'TIWARI', 1, 2, 7, 141, 28, '0', 'sanju.tiwari@vnrseeds.com', 'M', 'N', 'N', 1, '2011-02-17', '2013-11-23', '132702', NULL),
(171, 332, 'E', 'D', 'Mr.', 'P.SAMPATH', 'KUMAR', '', 1, 1, 2, 134, 209, '0', 'p.sampath.kumar@vnrseeds.com', 'M', 'Y', 'N', 7, '2011-02-16', '2013-07-02', '132685', NULL),
(172, 333, 'E', 'A', 'Mr.', 'SUJIT', 'KUMAR', 'SAHOO', 1, 63, 3, 567, 625, '9908520637', 'sujit.k.sahu@vnrseeds.com', 'M', 'Y', 'N', 20, '2011-02-16', NULL, '489407', NULL),
(173, 334, 'E', 'D', 'Mr.', 'AKHILESH', 'KUMAR', 'RAI', 1, 65, 6, 255, 14, '9377340335', 'akhilesh.rai@vnrseeds.com', 'M', 'Y', 'N', 71, '2011-03-09', '2016-02-22', '353066', NULL),
(174, 338, 'E', 'D', 'Mr.', 'YALAMADDI', 'VENKATESWAR', 'RAO', 1, 65, 6, 255, 597, '8008278811', 'venkateswar.rao@vnrseeds.com', 'M', 'Y', 'N', 106, '2011-04-16', '2018-06-28', '643916', NULL),
(175, 339, 'E', 'A', 'Mr.', 'JEEVAN ', 'LAL', 'BANJARE', 1, 64, 5, 392, 52, '9826629210', '', 'M', 'Y', 'N', 14, '2011-04-22', NULL, '348755', NULL),
(176, 340, 'E', 'D', 'Ms.', 'PRIYANKA', '', 'PANDEY', 1, 63, 5, 119, 52, '0', 'priyanka.pandey@vnrseeds.in', 'F', 'N', 'N', 14, '2011-04-22', '2016-03-28', '151110', NULL),
(177, 341, 'E', 'D', 'Mr.', 'LOKESH', '', 'KUMAR', 1, 15, 5, 120, 52, '0', '', 'M', 'N', 'N', 14, '2011-04-22', '2013-04-15', '80227', NULL),
(178, 342, 'E', 'A', 'Mrs.', 'TEENA', '', '', 1, 65, 5, 460, 52, '7805970505', 'vspl.teena@gmail.com', 'F', 'Y', 'N', 14, '2011-04-22', NULL, '420751', NULL),
(179, 343, 'E', 'A', 'Mr.', 'SANDEEP', 'KUMAR', '', 1, 71, 2, 2, 89, '9948793370', 'sandeep.kumar@vnrseeds.com', 'M', 'Y', 'N', 7, '2011-04-30', NULL, '1698585', NULL),
(180, 344, 'E', 'A', 'Mr.', 'BIRENDRA', 'KUMAR', 'SAHU', 1, 64, 5, 52, 52, '9009996313', 'bksahu1986@gmail.com', 'M', 'Y', 'N', 14, '2011-05-12', NULL, '429844', NULL),
(181, 345, 'E', 'D', 'Mr.', 'CHAND', 'BUDDHU', 'KALEPIRU', 1, 3, 5, 126, 52, '0', '', 'M', 'N', 'N', 14, '2011-05-16', '2013-02-09', '175042', NULL),
(182, 346, 'E', 'A', 'Mr.', 'DEBRAT', '', 'ROY', 1, 68, 1, 199, 142, '9300456007', 'debrat.roy@vnrseeds.com', 'M', 'Y', 'N', 1, '2011-05-27', NULL, '800006', NULL),
(183, 348, 'E', 'D', 'Mr.', 'JHALENDRA', '', 'KUMAR', 1, 63, 7, 207, 28, '0', 'jkumar.sahu@vnrseeds.com', 'M', 'Y', 'N', 1, '2011-06-01', '2017-04-22', '218656', NULL),
(184, 349, 'E', 'D', 'Mr.', 'DEEPAK', 'KUMAR', 'SINGH', 1, 3, 6, 70, 0, '0', '', 'M', 'N', 'N', 73, '2011-06-03', '2012-12-03', '190504', NULL),
(185, 350, 'E', 'D', 'Mr.', 'JYOTI ', 'PRAKASH', 'SINGHANIA', 1, 8, 8, 111, 110, '9981995394', 'jyoti.prakash@vnrseeds.com', 'M', 'Y', 'N', 1, '2011-06-09', '2013-05-18', '430415', NULL),
(186, 351, 'E', 'D', 'Mr.', 'BHUPENDRA', '', 'SINGH', 1, 65, 6, 255, 550, '9785205650', 'bhupendra.singh@vnrseeds.com', 'M', 'Y', 'N', 74, '2011-06-06', '2019-12-31', '576402', NULL),
(187, 352, 'E', 'D', 'Mr.', 'GATTU', '', 'CHANDRA SEKHAR', 1, 3, 6, 70, 220, '9392140330', 'g.chandrashekhar@vnrseeds.com', 'M', 'Y', 'N', 22, '2011-06-13', '2013-09-10', '221631', NULL),
(188, 353, 'E', 'D', 'Dr.', 'RAVI', 'SHANKAR', 'VERMA', 1, 69, 2, 3, 89, '0', 'rnd.ravishankar@vnrseeds.com', 'M', 'Y', 'Y', 9, '2011-06-14', '2016-02-20', '724754', NULL),
(189, 354, 'E', 'D', 'Ms.', 'SUSMITA', '', 'TRIPATHY', 1, 64, 12, 77, 97, '9302440330', 'susmita.tripathy@vnrseeds.com', 'F', 'N', 'N', 1, '2011-06-20', '2015-11-02', '431703', NULL),
(190, 355, 'E', 'D', 'Mr.', 'PARTHASARATHI', '', 'PANDA', 1, 3, 6, 70, 0, '0', '', 'M', 'N', 'N', 76, '2011-06-20', '2012-08-31', '0', NULL),
(191, 356, 'E', 'D', 'Mr.', 'SATISH', 'N', 'BHAT', 1, 69, 6, 67, 79, '9341335330', 'satish.bhat@vnrseeds.com', 'M', 'Y', 'N', 77, '2011-07-14', '2016-12-12', '936677', NULL),
(192, 357, 'E', 'D', 'Mr.', 'GIRDHARI', '', 'BIRLA', 1, 65, 6, 255, 924, '9926052317', 'girdhari.birla@vnrseeds.com', 'M', 'Y', 'N', 78, '2011-09-01', '2020-12-31', '436091', NULL),
(193, 360, 'E', 'D', 'Ms.', 'SUMANA', '', 'BOSE', 1, 1, 11, 114, 142, '0', 'reception@vnrseeds.com', 'F', 'N', 'N', 1, '2011-10-01', '2013-01-14', '135085', NULL),
(194, 361, 'E', 'D', 'Mr.', 'NITIN', '', 'CHAUDHARY', 1, 0, 0, 0, 0, '0', '', 'M', 'N', 'N', 0, NULL, NULL, '0', NULL),
(195, 362, 'E', 'A', 'Dr.', 'HARI  ', 'PRASAD', '', 1, 73, 25, 195, 6, '9981995392', 'hariprasad.verma@vnrseeds.in', 'M', 'Y', 'Y', 14, '2011-11-21', NULL, '3019213', NULL),
(196, 363, 'E', 'D', 'Mr.', 'DAHATONDE', 'PRASHANT', 'BABASAHEB', 1, 63, 6, 254, 106, '9326940330', 'd.Prashant@vnrseeds.com', 'M', 'Y', 'N', 79, '2011-12-16', '2015-08-03', '232294', NULL),
(197, 364, 'E', 'A', 'Mr.', 'RAJU', '', 'BISTA', 1, 64, 25, 217, 195, '9010758165', 'raju.bista@vnrseeds.in', 'M', 'Y', 'N', 7, '2011-12-16', NULL, '510002', NULL),
(198, 365, 'E', 'A', 'Mr.', 'S.PRAVEEN', 'KUMAR', '', 1, 63, 2, 131, 507, '9951458293', 's.praveenkumar8293@gmail.com', 'M', 'N', 'N', 7, '2011-12-16', NULL, '492540', NULL),
(199, 366, 'E', 'A', 'Mr.', 'HATKAR ', 'JALBA', 'DATTA', 1, 62, 25, 430, 195, '8096146310', '', 'M', 'Y', 'N', 7, '2011-12-16', NULL, '290473', NULL),
(200, 367, 'E', 'A', 'Mr.', 'VANKDAVATH', '', 'PRASAD', 1, 62, 2, 249, 179, '9666386355', 'prasad.vnr2016@gmail.com', 'M', 'Y', 'N', 7, '2011-12-16', NULL, '434355', NULL),
(201, 368, 'E', 'D', 'Mr.', 'GIRISH', '', 'TRIPATHI', 1, 62, 6, 256, 308, '0', 'girish.tripathi@vnrseeds.com', 'M', 'Y', 'N', 80, '2011-12-27', '2014-07-28', '149862', NULL),
(202, 369, 'E', 'D', 'Mr.', 'SHIV', 'KUMAR', '', 1, 3, 6, 70, 4, '9336520004', 'shiv.kumar@vnrseeds.com', 'M', 'N', 'N', 81, '2012-02-22', '2013-03-11', '245045', NULL),
(203, 370, 'E', 'D', 'Mr.', 'PRATIK ', 'M', 'PATLE', 1, 62, 6, 256, 57, '9373440330', 'pratik.patle@vnrseeds.com', 'M', 'Y', 'N', 82, '2012-03-05', '2014-11-22', '140262', NULL),
(204, 371, 'E', 'D', 'Mr.', 'MANMOHAN', '', 'RAI', 1, 64, 5, 392, 52, '0', '', 'M', 'Y', 'N', 14, '2012-04-02', '2018-03-11', '359107', NULL),
(205, 372, 'E', 'A', 'Mr.', 'SAIYYAD', 'SUHAIL', 'HUSSAIN', 1, 66, 5, 462, 52, '9589281500', 'saiyyad.suhail@vnrseeds.in', 'M', 'N', 'N', 14, '2012-04-16', NULL, '551070', NULL),
(206, 373, 'E', 'D', 'Mr.', 'AMBRISH', '', 'SHARMA', 1, 3, 6, 70, 0, '9314322888', 'ambrish.sharma@vnrseeds.com', 'M', 'Y', 'N', 83, '2012-04-19', '2013-02-06', '189572', NULL),
(207, 374, 'E', 'D', 'Mr.', 'ROHIT', '', 'YADAV', 1, 2, 5, 124, 52, '0', 'rohit.yadav@vnrseeds.in', 'M', 'N', 'N', 14, '2012-05-02', '2013-05-09', '103885', NULL),
(208, 375, 'E', 'A', 'Mr.', 'RAJESH', 'PAL', 'SINGH', 1, 67, 5, 464, 52, '9303640335', 'rajesh.pal@vnrseeds.in', 'M', 'Y', 'N', 14, '2012-05-05', NULL, '648507', NULL),
(209, 376, 'E', 'A', 'Dr.', 'AKHIL ', '', 'ANAND', 1, 70, 2, 2, 7, '9542199252', 'akhil.anand@vnrseeds.com', 'M', 'Y', 'Y', 12, '2012-05-09', NULL, '1424399', NULL),
(210, 377, 'E', 'D', 'Mrs.', 'SHRADDHA', '', 'GUPTA', 1, 67, 2, 250, 89, '0', 'sharaddha.gupta@vnrseeds.com', 'F', 'Y', 'N', 1, '2012-05-14', '2018-09-06', '586309', NULL),
(211, 378, 'E', 'D', 'Mr.', 'TIRATH ', 'RAM', 'PATEL', 1, 3, 5, 59, 52, '0', '', 'M', 'N', 'N', 14, '2012-05-14', '2013-12-21', '178662', NULL),
(212, 379, 'E', 'D', 'Dr.', 'MANGALDEEP', '', 'SARKAR', 1, 7, 2, 5, 89, '0', 'mangaldeep.sarkar@vnrseeds.com', 'M', 'N', 'Y', 7, '2012-05-15', '2013-12-10', '453165', NULL),
(213, 380, 'E', 'D', 'Mr.', 'NANDKISHOR', '', 'TAYDE', 1, 63, 4, 226, 73, '0', '', 'M', 'Y', 'N', 90, '2012-05-25', '2015-04-25', '158550', NULL),
(214, 381, 'E', 'D', 'Mr.', 'AKHILESH', '', 'SRIVASTAVA', 1, 2, 6, 70, 34, '0', '', 'M', 'N', 'N', 85, '2012-06-01', '2012-11-20', '148345', NULL),
(215, 382, 'E', 'D', 'Mr.', 'SUNDER L', '', '', 1, 64, 6, 257, 514, '9341240330', 'sunder.l@vnrseeds.com', 'M', 'Y', 'N', 215, '2012-06-01', '2018-05-30', '391157', NULL),
(216, 383, 'E', 'D', 'Mr.', 'VAIBHAV', '', 'VERMA', 1, 66, 6, 68, 140, '9302240330', 'vaibhav.verma@vnrseeds.com', 'M', 'Y', 'N', 87, '2012-06-07', '2018-02-13', '675428', NULL),
(217, 384, 'E', 'A', 'Mr.', 'SUMAN', 'KUMAR', 'SAJJAN', 1, 66, 6, 68, 261, '9386388099', 'sk.sajjan@vnrseeds.com', 'M', 'Y', 'N', 10, '2012-06-11', NULL, '836221', NULL),
(218, 385, 'E', 'D', 'Mr.', 'SHASHI', 'MOHAN', 'SEN', 1, 7, 8, 112, 223, '9981993070', 'shashi.mohan@vnrseeds.com', 'M', 'N', 'N', 1, '2012-07-02', '2013-01-31', '0', NULL),
(219, 386, 'E', 'D', 'Mr.', 'BINDESHWAR', '', 'SINGH', 1, 62, 6, 256, 168, '9305240330', 'bindeshwar.singh@vnrseeds.com', 'M', 'Y', 'N', 70, '2012-07-12', '2015-09-09', '143070', NULL),
(220, 387, 'E', 'A', 'Mr.', 'P. SRINIVASA', '', 'SWAMY', 1, 71, 6, 66, 531, '9346640330', 'psrinivas.swamy@vnrseeds.com', 'M', 'Y', 'N', 7, '2012-07-13', NULL, '2061177', NULL),
(221, 388, 'E', 'D', 'Mr.', 'P. KOMURAIAH', '', '', 1, 63, 2, 131, 66, '0', '', 'M', 'Y', 'N', 7, '2012-07-23', '2018-08-03', '334538', NULL),
(222, 389, 'E', 'A', 'Mr.', 'SHIREESH', '', 'GUPTA', 1, 65, 6, 255, 14, '9425892798', 'shireesh.gupta@vnrseeds.com', 'M', 'Y', 'N', 88, '2012-08-03', NULL, '502518', NULL),
(223, 10001, 'E', 'A', 'Mr.', 'ARVIND', 'KUMAR', 'AGRAWAL', 1, 0, 17, 110, 0, '9329570007', 'fd@vnrseeds.com', 'M', 'Y', 'N', 1, '2009-02-02', NULL, '0', NULL),
(224, 10002, 'E', 'A', 'Mr.', 'VIMAL', '', 'CHAWDA', 1, 0, 17, 171, 0, '9981990330', 'vimal.chawda@vnrseeds.com', 'M', 'Y', 'N', 1, '2005-04-01', NULL, '0', NULL),
(227, 392, 'E', 'D', 'Mr.', 'LAKHENDRA ', '', 'SINGH', 1, 6, 24, 150, 263, '0', 'lakhendra.singh@vnrseeds.in', 'M', 'N', 'N', 14, '2012-08-10', '2013-06-07', '306045', NULL),
(228, 1, 'E', 'D', 'Mr.', 'OMKAR ', '', 'MAHILANG', 2, 16, 13, 152, 235, '0', '', 'M', 'Y', 'N', 92, '2010-01-01', '2017-12-31', '180000', NULL),
(229, 2, 'E', 'A', 'Mr.', 'RAM LAL ', '', 'LODHI', 2, 20, 13, 153, 0, '0', 'ra@g.com', 'M', 'N', 'N', 92, '2010-04-01', NULL, '252000', NULL),
(230, 3, 'E', 'D', 'Mr.', 'ROSHAN LAL ', '', 'SONKE', 2, 17, 14, 154, 0, '0', 'ro@c.com', 'M', 'N', 'N', 92, '2010-04-01', NULL, '102000', NULL),
(231, 4, 'E', 'A', 'Ms.', 'VIMLA ', '', 'SAHU', 2, 17, 15, 155, 0, '0', 'vi@g.com', 'F', 'N', 'N', 92, '2010-04-01', NULL, '105600', NULL),
(232, 5, 'E', 'A', 'Ms.', 'KIRAN ', '', 'JOSHI', 2, 17, 16, 155, 229, '0', '', 'F', 'N', 'N', 92, '2011-05-27', NULL, '108000', NULL),
(233, 1001, 'E', 'A', 'Mr.', 'ARVIND', '', 'AGRAWAL', 2, 0, 18, 110, 0, '0', '', 'M', 'Y', 'N', 92, NULL, NULL, '0', NULL),
(234, 1002, 'E', 'A', 'Mr.', 'VIMAL', '', 'CHAWADA', 2, 0, 18, 109, 0, '0', '', 'M', 'Y', 'N', 92, NULL, NULL, '0', NULL),
(235, 1003, 'E', 'A', 'Mr.', 'KRISHAN CHANDRA', '', 'UPADHYAY', 2, 14, 18, 116, 0, '8008261509', 'kc@vnrseeds.com', 'M', 'Y', 'N', 7, '2005-12-03', NULL, '0', NULL),
(236, 390, 'E', 'D', 'Mr.', 'N.SHIVAJI ', '', 'GANESH', 1, 66, 5, 464, 56, '9848010569', 'nshivajiganesh.vspl@gmail.com', 'M', 'Y', 'N', 155, '2012-08-10', NULL, '544680', NULL),
(237, 393, 'E', 'D', 'Mr.', 'HUMBAD  ', 'MADHAV', 'DNYANABA', 1, 62, 6, 69, 106, '9326814195', 'humbad.madhav@vnrseeds.com', 'M', 'Y', 'N', 93, '2012-08-16', '2014-06-11', '195702', NULL),
(238, 394, 'E', 'A', 'Mr.', 'UDDANDAM', 'MAHESH', 'BABU', 1, 70, 3, 298, 719, '7799990660', 'mahesh.babu@vnrseeds.com', 'M', 'Y', 'N', 285, '2012-09-01', NULL, '1375704', NULL),
(239, 395, 'E', 'D', 'Mrs.', 'V PRATIBHA ', '', 'MOHAN', 1, 7, 2, 16, 7, '0', 'pratibha.mohan@vnrseeds.com', 'F', 'Y', 'N', 15, '2012-09-01', '2013-05-04', '294677', NULL),
(240, 396, 'E', 'D', 'Mr.', 'KAUSTUBH ', '', 'CHATURVEDI', 1, 2, 6, 70, 14, '9304040330', 'kaustubh.chaturvedi@vnrseeds.com', 'M', 'N', 'N', 59, '2012-09-26', '2013-08-27', '204102', NULL),
(241, 397, 'E', 'A', 'Mr.', 'MOHD. AMIR ', '', 'KHAN', 1, 73, 6, 65, 531, '7544007770', 'amir.khan@vnrseeds.com', 'M', 'Y', 'N', 1, '2012-11-05', NULL, '3410056', NULL),
(242, 398, 'E', 'D', 'Mr.', 'BABLU ', '', '.', 1, 64, 5, 438, 52, '7869638906', 'bablu04dec@gmail.com', 'M', 'Y', 'N', 14, '2012-11-20', '2020-10-10', '419795', NULL),
(243, 399, 'E', 'D', 'Mr.', 'ASHWINI ', 'KUMAR', ' RAI', 1, 62, 5, 124, 52, '0', '', 'M', 'Y', 'N', 14, '2012-11-26', '2017-07-17', '221932', NULL),
(244, 400, 'E', 'D', 'Mr.', 'PRADEEP ', 'S', 'NANDIKESHWARAMATH', 1, 61, 4, 225, 24, '0', '', 'M', 'N', 'N', 94, '2012-12-01', '2014-10-11', '126102', NULL),
(245, 401, 'E', 'D', 'Mr.', 'B. KIRAN', 'KUMAR', 'REDDY', 1, 0, 5, 126, 56, '0', '', 'M', 'N', 'N', 29, '2012-12-03', '2014-02-10', '163782', NULL),
(246, 402, 'E', 'A', 'Mr.', 'JAGDEEP', '', 'KUMAR', 1, 70, 5, 459, 52, '9302740330', 'jagdeep.kumar@vnrseeds.in', 'M', 'Y', 'N', 14, '2012-12-03', NULL, '1602273', NULL),
(247, 403, 'E', 'D', 'Mr.', 'MANOJ', '', 'KUMAR', 1, 65, 6, 255, 399, '9198340007', 'manoj.kumar@vnrseeds.com', 'M', 'Y', 'N', 2, '2012-12-17', '2016-10-11', '412893', NULL),
(248, 404, 'E', 'D', 'Mr.', 'RITESH ', '', 'KUMAR ', 1, 64, 6, 257, 241, '0', '', 'M', 'Y', 'N', 3, '2012-12-21', '2014-07-19', '299729', NULL),
(249, 405, 'E', 'D', 'Mr.', 'HIMANSU', 'SEKHAR ', 'MISHRA ', 1, 5, 6, 69, 140, '9338640330', 'himanshu.mishra@vnrseeds.com', 'M', 'Y', 'N', 76, '2012-12-25', '2013-05-09', '344800', NULL),
(250, 406, 'E', 'A', 'Mr.', 'RAM ', 'PRASAD ', 'SINGH ', 1, 67, 6, 415, 449, '9198160007', 'ramprasad.singh@vnrseeds.com', 'M', 'Y', 'N', 4, '2013-01-03', NULL, '1071044', NULL),
(251, 407, 'E', 'D', 'Mr.', 'DHIRAJ ', 'SUBHASHRAO', 'KADAM ', 1, 2, 6, 70, 106, '9370440330', 's.kadam@vnrseeds.com', 'M', 'N', 'N', 96, '2013-01-15', '2013-07-01', '155485', NULL),
(252, 408, 'E', 'A', 'Mr.', 'SANJAY', '', 'SINGH', 1, 70, 6, 66, 531, '7544007776', 'sanjay.singh@vnrseeds.com', 'M', 'Y', 'N', 1, '2013-01-16', NULL, '1750925', NULL),
(253, 409, 'E', 'D', 'Mr.', 'DINESH', '', 'SHARMA', 1, 64, 6, 257, 11, '8295199330', 'dinesh.sharma@vnrseeds.com', 'M', 'Y', 'N', 160, '2013-01-21', '2016-12-03', '319929', NULL),
(254, 1, 'E', 'A', 'Mr.', 'DEVESH ', '', 'SHUKLA', 3, 35, 19, 160, 260, '9981995393', 'devesh.shukla@vnrnursery.in', 'M', 'Y', 'N', 102, '2012-03-01', NULL, '6000397', NULL),
(255, 3, 'E', 'D', 'Mr.', 'PITAMBER ', '', 'LAL', 3, 34, 20, 161, 254, '0', '', 'M', 'Y', 'N', 102, '2012-03-10', NULL, '210000', NULL),
(256, 7, 'E', 'D', 'Mr.', 'ANURAG ', '', 'MISHRA', 3, 33, 19, 162, 254, '0', '', 'M', 'N', 'N', 104, '2012-07-16', '2014-03-31', '222000', NULL),
(257, 8, 'E', 'D', 'Ms.', 'UMA ', 'SINGH', 'BAGHEL', 3, 31, 26, 295, 254, '0', 'customer.service@vnrnursery.in', 'F', 'N', 'N', 102, '2012-10-15', '2018-07-05', '257394', NULL),
(258, 9, 'E', 'D', 'Mr.', 'PRADEEP ', '', 'GANGWAR', 3, 32, 21, 164, 254, '0', 'pradeep.gangwar@vnrnursery.in', 'M', 'N', 'N', 103, '2013-01-09', '2015-08-31', '372000', NULL),
(259, 1001, 'E', 'A', 'Mr.', 'ARVIND ', '', 'AGRAWAL', 3, 0, 23, 165, 0, '9329570007', 'fd@vnrseeds.com', 'M', 'Y', 'N', 102, '2009-02-02', NULL, '0', NULL),
(260, 1002, 'E', 'A', 'Mr.', 'VIMAL ', '', 'CHAWDA', 3, 0, 23, 166, 0, '9981990330', 'vimal.chawda@vnrseeds.com', 'M', 'Y', 'N', 102, '2005-04-01', NULL, '0', NULL),
(261, 410, 'E', 'A', 'Mr.', 'RAJEEV', '', 'RANJAN', 1, 70, 6, 66, 4, '9303040330', 'rajeev.ranjan@vnrseeds.com', 'M', 'Y', 'N', 10, '2013-02-09', NULL, '1966093', NULL),
(262, 411, 'E', 'D', 'Mr.', 'BALAYAGARI', 'CHINNA', 'REDDY', 1, 63, 6, 254, 220, '9390440330', 'bc.reddy@vnrseeds.com', 'M', 'Y', 'N', 7, '2013-02-11', '2016-07-14', '334770', NULL),
(263, 412, 'E', 'A', 'Mr.', 'SHEKHAR', 'CHANDRA', 'SATI', 1, 75, 24, 364, 6, '9981993070', 'sc.sati@vnrseeds.com', 'M', 'Y', 'N', 14, '2013-02-15', NULL, '5646689', NULL),
(264, 413, 'E', 'D', 'Mr.', 'CHANDRA ', 'PRAKASH', 'DEWANGAN', 1, 67, 8, 191, 110, '0', 'cp.dewangan@vnrseeds.com', 'M', 'Y', 'N', 1, '2013-03-11', '2015-03-20', '420815', NULL),
(265, 414, 'E', 'A', 'Mr.', 'MUKESH', 'KUMAR', 'KHURSE', 1, 64, 5, 51, 52, '9907195151', 'mukesh99.power@gmail.com', 'M', 'Y', 'N', 14, '2013-03-28', NULL, '520263', NULL),
(266, 415, 'E', 'A', 'Mr.', 'GYAN', 'PRAKASH', 'PAL', 1, 68, 25, 221, 195, '9179042140', 'gp.pal@vnrseeds.in', 'M', 'Y', 'N', 118, '2013-04-10', NULL, '678942', NULL),
(267, 416, 'E', 'D', 'Mr.', 'PREM ', 'PRAKASH', 'SINGH', 1, 62, 5, 119, 52, '0', 'pp.singh@vnrseeds.in', 'M', 'N', 'N', 14, '2013-04-19', '2018-08-18', '255188', NULL),
(268, 417, 'E', 'D', 'Mr.', 'AMIT ', 'KUMAR', 'PATEL ', 1, 2, 5, 124, 52, '0', '', 'M', 'N', 'N', 14, '2013-04-22', '2013-05-11', '105085', NULL),
(269, 418, 'E', 'D', 'Mr.', 'HARISH ', 'RAMDASJI', 'RAUT', 1, 3, 5, 123, 52, '0', '', 'M', 'N', 'N', 14, '2013-04-22', '2013-10-12', '200271', NULL),
(270, 419, 'E', 'A', 'Mr.', 'VIKAS', '', 'KUMAR', 1, 65, 6, 255, 915, '9308940330', 'vikas.kumar@vnrseeds.com', 'M', 'Y', 'N', 109, '2013-05-06', NULL, '549768', NULL),
(271, 420, 'E', 'D', 'Mr.', 'RACHIT ', '', 'INANI', 1, 7, 8, 112, 110, '9981991071', 'rachit.inani@vnrseeds.com', 'M', 'N', 'N', 1, '2013-05-15', '2013-06-28', '294677', NULL),
(272, 421, 'E', 'D', 'Ms.', 'MUDRA', '', 'KHARE', 1, 67, 2, 5, 108, '0', 'mudra.khare@vnrseeds.com', 'F', 'N', 'N', 7, '2013-05-20', '2014-05-31', '332569', NULL),
(273, 422, 'E', 'D', 'Mr.', 'KISHOR', '', 'YADU', 1, 62, 7, 141, 28, '0', 'kishore.yadu@vnrseeds.com', 'M', 'N', 'N', 1, '2013-05-20', '2016-07-01', '155762', NULL),
(274, 423, 'E', 'A', 'Mr.', 'AKHILESH ', '', 'CHANDRA', 1, 66, 6, 68, 438, '9308040330', 'ak.chandra@vnrseeds.com', 'M', 'Y', 'N', 47, '2013-06-06', NULL, '719803', NULL),
(275, 424, 'E', 'D', 'Mr.', 'SUMANT', 'KUMAR ', 'MAURYA', 1, 65, 6, 255, 261, '7488240330', 'sumant.m@vnrseeds.com', 'M', 'Y', 'N', 232, '2013-06-10', '2018-12-01', '413313', NULL),
(276, 425, 'E', 'D', 'Mr.', 'ERRI', 'VENKAT', 'REDDY', 1, 1, 6, 71, 220, '0', 'ev.reddy@vnrseeds.com', 'M', 'Y', 'N', 47, '2013-06-10', '2013-10-28', '114582', NULL),
(278, 426, 'E', 'D', 'Mr.', 'SANJEEV', '', 'KUMAR', 1, 63, 3, 215, 15, '0', 'sanjeev.kumar@vnrseeds.in', 'M', 'N', 'N', 3, '2013-07-01', '2016-05-05', '343348', NULL),
(279, 427, 'E', 'A', 'Mr.', 'KUSH', 'DATT', 'RAWAT', 1, 67, 4, 372, 52, '9981995345', 'kush.dutt@vnrseeds.in', 'M', 'N', 'N', 260, '2013-07-01', NULL, '1012425', NULL),
(280, 428, 'E', 'D', 'Mr.', 'RAJEEV', '', 'KUMAR', 1, 3, 4, 169, 35, '0', 'rajeev.kumar@vnrseeds.in', 'M', 'N', 'N', 22, '2013-07-01', '2013-11-02', '243722', NULL),
(281, 429, 'E', 'A', 'Ms.', 'POOJA', '', 'RAWAT', 1, 67, 2, 259, 224, '9589079609', 'pooja.rawat@vnrseeds.com', 'F', 'N', 'N', 15, '2013-07-01', NULL, '875584', NULL),
(282, 430, 'E', 'D', 'Mr.', 'KIRAN', '', 'P', 1, 67, 2, 5, 89, '0', 'kiran.p@vnrseeds.in', 'M', 'N', 'N', 7, '2013-07-01', '2014-01-25', '269415', NULL),
(283, 431, 'E', 'A', 'Mr.', 'MURALI', '', 'ERUKU', 1, 69, 2, 3, 7, '9505454712', 'murali.e@vnrseeds.in', 'M', 'Y', 'N', 7, '2013-07-01', NULL, '1096616', NULL),
(284, 432, 'E', 'D', 'Mr.', 'SANWAR', '', 'MAL', 1, 64, 4, 306, 145, '9981995346', 'sanwar.mal@vnrseeds.in', 'M', 'N', 'N', 84, '2013-07-01', '2015-03-09', '262514', NULL),
(285, 433, 'E', 'D', 'Mr.', 'ANAND', 'KISHORE', 'GUPTA', 1, 3, 4, 169, 35, '0', 'ak.gupta@vnrseeds.in', 'M', 'N', 'N', 22, '2013-07-01', '2013-11-22', '204102', NULL),
(286, 434, 'E', 'D', 'Mr.', 'SRINIVAS', '', 'MAMINDLA', 1, 64, 4, 306, 35, '0', 'm.srinivas@vnrseeds.in', 'M', 'N', 'N', 22, '2013-07-01', '2014-10-01', '204102', NULL),
(287, 435, 'E', 'D', 'Mr.', 'RAJKANT', '', 'MISHRA', 1, 63, 3, 215, 51, '8689026524', 'rajkant.mishra@vnrseeds.in', 'M', 'N', 'N', 8, '2013-07-01', '2014-03-06', '217308', NULL),
(288, 10, 'E', 'D', 'Mrs.', 'KHUSHBOO', '', 'JETHI', 3, 31, 22, 163, 254, '0', '', 'F', 'Y', 'N', 102, '2013-06-10', NULL, '90000', NULL),
(289, 11, 'E', 'D', 'Mr.', 'PRITESH ', 'SINH', 'VAGHELA', 3, 37, 19, 181, 254, '0', '', 'M', 'Y', 'N', 111, '2013-06-17', '2014-04-30', '806400', NULL),
(290, 12, 'E', 'A', 'Mr.', 'NARENDRA', '', 'VERMA', 3, 32, 20, 426, 254, '0', 'accounts@vnrnursery.in', 'M', 'Y', 'N', 102, '2013-07-01', NULL, '530081', NULL),
(291, 13, 'E', 'D', 'Ms.', 'PRATIMA', '', 'GUPTA', 3, 35, 21, 180, 254, '0', '', 'F', 'N', 'N', 102, '2013-07-01', '2014-04-14', '246000', NULL),
(292, 14, 'E', 'D', 'Mr.', 'RAJEEV ', '', 'BHASKAR', 3, 32, 19, 419, 254, '7509494023', 'rajeev.bhaskar@vnrnursery.in', 'M', 'N', 'N', 102, '2013-07-01', '2017-09-30', '556000', NULL),
(293, 436, 'E', 'D', 'Mr.', 'SANTOSH', 'JAGNNATH', 'VIBHUTE', 1, 64, 6, 257, 431, '9370440330', 'santosh.vibhute@vnrseeds.in', 'M', 'Y', 'N', 112, '2013-07-24', '2016-02-11', '361266', NULL),
(294, 437, 'E', 'A', 'Mr.', 'YOGESH', 'SURESH', 'NIBE', 1, 69, 24, 551, 263, '8197346701', 'yogesh.n@vnrseeds.in', 'M', 'Y', 'N', 14, '2013-08-01', NULL, '913487', NULL),
(295, 438, 'E', 'D', 'Mr.', 'KAPTAN', '', 'SINGH', 1, 61, 6, 174, 86, '7742128134', 'kaptan.singh@vnrseeds.com', 'M', 'N', 'N', 113, '2013-08-01', '2014-06-20', '139302', NULL),
(296, 439, 'E', 'D', 'Mr.', 'RAMPRAKASH', '', 'SHARMA', 1, 61, 6, 174, 86, '9772990950', 'ramprakash.sharma@vnrseeds.com', 'M', 'Y', 'N', 114, '2013-08-01', '2014-09-10', '139302', NULL),
(297, 440, 'E', 'A', 'Mr.', 'R', '', 'ANJAIAH', 1, 66, 6, 68, 220, '9396640330', 'r.anjaiah@vnrseeds.com', 'M', 'Y', 'N', 22, '2013-10-09', NULL, '582480', NULL),
(298, 441, 'E', 'D', 'Mr.', 'RAVI', '', 'GAUR', 1, 65, 24, 237, 334, '0', 'ravi.gaur@vnrseeds.com', 'M', 'Y', 'N', 14, '2013-10-15', '2016-06-24', '342969', NULL),
(299, 442, 'E', 'D', 'Mr.', 'UDAY', 'PRATAP ', 'SINGH', 1, 5, 5, 144, 52, '0', '', 'M', 'Y', 'N', 14, '2013-10-18', '2014-01-04', '198102', NULL),
(300, 443, 'E', 'A', 'Mr.', 'DEEPANKAR', '', 'SARKAR', 1, 68, 40, 573, 65, '9993196234', 'd.sarkar@vnrseeds.com', 'M', 'Y', 'N', 1, '2013-11-06', NULL, '882966', NULL),
(301, 444, 'E', 'A', 'Mr.', 'LAXMAN ', 'KUMAR', 'BAG', 1, 65, 2, 135, 601, '8349180872', 'laxmank.bag@vnrseeds.com', 'M', 'Y', 'N', 1, '2013-11-06', NULL, '412813', NULL),
(302, 445, 'E', 'D', 'Mr.', 'AMIT', 'KUMAR', 'TIWARI', 1, 61, 25, 169, 52, '0', '', 'M', 'N', 'N', 14, '2013-12-20', '2014-11-06', '199902', NULL);
INSERT INTO `master_employee` (`EmployeeID`, `EmpCode`, `EmpType`, `EmpStatus`, `Title`, `Fname`, `Sname`, `Lname`, `CompanyId`, `GradeId`, `DepartmentId`, `DesigId`, `RepEmployeeID`, `Contact`, `Email`, `Gender`, `Married`, `DR`, `Location`, `DOJ`, `DateOfSepration`, `CTC`, `LastUpdated`) VALUES
(303, 446, 'E', 'D', 'Mr.', 'RAMVEER', '', 'SHARMA', 1, 64, 6, 257, 438, '8953780330', 'ramveer.sharma@vnrseeds.com', 'M', 'Y', 'N', 81, '2013-12-24', '2018-04-23', '375406', NULL),
(304, 447, 'E', 'D', 'Mr.', 'RAVI', '', 'K G', 1, 61, 6, 174, 191, '0', '', 'M', 'Y', 'N', 115, '2013-12-26', '2015-03-25', '134382', NULL),
(305, 448, 'E', 'D', 'Mr.', 'BHARAT', 'M', 'PATEL', 1, 62, 6, 256, 14, '9662050330', 'bmpatel.vnr@gmail.com', 'M', 'Y', 'N', 116, '2014-01-06', '2016-11-18', '219593', NULL),
(306, 449, 'E', 'D', 'Mr.', 'MAMUNOORI', '', 'SHYAM', 1, 62, 6, 256, 220, '0', '', 'M', 'Y', 'N', 117, '2014-01-10', '2014-04-12', '144102', NULL),
(307, 450, 'E', 'A', 'Mr.', 'LEKHRAM', '', 'SAHU', 1, 63, 7, 207, 28, '9977599313', 'lksahu.vnr@gmail.com', 'M', 'Y', 'N', 1, '2014-01-13', NULL, '299603', NULL),
(308, 451, 'E', 'D', 'Mr.', 'PAVAN', '', 'KUMAR', 1, 71, 6, 66, 140, '9179042137', 'pawan.kumar@vnrseeds.com', 'M', 'Y', 'N', 1, '2014-01-20', '2017-12-14', '1738404', NULL),
(309, 452, 'E', 'A', 'Mr.', 'SANJAY', '', 'KUMAR', 1, 70, 4, 156, 35, '9640788800', 'sanjay.vnr@gmail.com', 'M', 'Y', 'N', 22, '2014-01-30', NULL, '1121131', NULL),
(310, 453, 'E', 'A', 'Mr.', 'SHIVSHARAN', '', 'SINGH', 1, 65, 6, 255, 924, '9179042139', 'shivsharan.vnr@gmail.com', 'M', 'Y', 'N', 201, '2014-02-01', NULL, '569036', NULL),
(311, 454, 'E', 'D', 'Mr.', 'VISHWANATH', 'K ', 'GIRASE', 1, 68, 2, 5, 89, '0', 'vishwanath.girase@vnrseeds.com', 'M', 'Y', 'N', 7, '2014-02-01', '2017-03-31', '672651', NULL),
(312, 455, 'E', 'D', 'Mr.', 'KAMLESHWAR', '', 'TIWARI', 1, 63, 6, 254, 62, '0', '', 'M', 'Y', 'N', 120, '2014-02-01', '2015-09-23', '217312', NULL),
(313, 456, 'E', 'A', 'Mr.', 'MAN', 'BAHADUR', 'DHAMI', 1, 62, 25, 430, 195, '9948605425', '', 'M', 'Y', 'N', 7, '2014-02-01', NULL, '340463', NULL),
(314, 457, 'E', 'D', 'Mr.', 'SALIK', 'RAM', 'GORATHOKI', 1, 62, 25, 430, 195, '9010912047', '', 'M', 'Y', 'N', 7, '2014-02-01', '2021-01-25', '295039', NULL),
(315, 458, 'E', 'D', 'Mr.', 'SANDEEP ', 'KUMAR', 'GAUR', 1, 65, 6, 255, 726, '7544007775', 'skgaur.vnr@gmail.com', 'M', 'Y', 'N', 67, '2014-02-04', '2019-08-25', '576892', NULL),
(316, 459, 'E', 'D', 'Mr.', 'CHANDRA', 'SHEKHAR', 'MISHRA', 1, 64, 6, 257, 375, '7682805994', '', 'M', 'N', 'N', 76, '2014-02-10', '2016-12-15', '436082', NULL),
(317, 460, 'E', 'D', 'Mr.', 'PANKAJ', 'KUMAR', 'DAS', 1, 63, 6, 254, 375, '0', '', 'M', 'N', 'N', 121, '2014-02-10', '2015-09-15', '252909', NULL),
(318, 461, 'E', 'D', 'Mr.', 'ANUP', 'SINGH', 'PARIHAR', 1, 65, 5, 144, 52, '0', '', 'M', 'N', 'N', 14, '2014-02-15', '2015-02-04', '377396', NULL),
(319, 462, 'E', 'A', 'Mr.', 'MAHENDRA ', 'KUMAR', 'PATLE', 1, 66, 6, 68, 252, '9179042142', 'mkpatle.vnr@gmail.com', 'M', 'Y', 'N', 1, '2014-02-20', NULL, '603763', NULL),
(320, 463, 'E', 'D', 'Mr.', 'LAKSHMI', 'SHANKAR', 'SINGH', 1, 68, 2, 294, 65, '0', '', 'M', 'Y', 'N', 15, '2014-02-26', '2015-08-12', '581042', NULL),
(321, 464, 'E', 'A', 'Mr.', 'RAJENDRA', 'SINGH', 'RANA', 1, 73, 3, 602, 7, '8295177330', 'rajendra.rana@vnrseeds.com', 'M', 'Y', 'N', 7, '2014-02-28', NULL, '3212413', NULL),
(322, 16, 'E', 'A', 'Mr.', 'RAHUL', 'KUMAR', 'DHIWAR', 3, 31, 19, 163, 254, '9981995368', 'rahul.dhiwar@vnrseeds.in', 'M', 'Y', 'N', 102, '2013-12-02', NULL, '315395', NULL),
(323, 465, 'E', 'D', 'Mr.', 'SANJAY ', '', 'KOHRE', 1, 63, 8, 193, 109, '0', '', 'M', 'Y', 'N', 1, '2014-03-18', '2014-08-26', '146742', NULL),
(324, 466, 'E', 'D', 'Mr.', 'DEVENDRA', 'KUMAR', 'DHIWAR', 1, 63, 24, 365, 382, '0', 'dkdhiwar.vnr@gmail.com', 'M', 'Y', 'N', 14, '2014-03-18', '2018-02-19', '247198', NULL),
(325, 467, 'E', 'D', 'Mr.', 'SURESH', 'TUKARAM', 'JADHAV', 1, 65, 24, 237, 382, '7024705888', 'stjadhav.vnr@gmail.com', 'M', 'Y', 'N', 14, '2014-03-20', '2015-12-26', '319509', NULL),
(326, 468, 'E', 'D', 'Mr.', 'KADARI ', '', 'SHANKAR', 1, 66, 24, 239, 263, '9989735160', 'kshankar.vnr@gmail.com', 'M', 'Y', 'N', 155, '2014-04-01', '2021-03-02', '462599', NULL),
(327, 469, 'E', 'D', 'Mr.', 'DEVARAPALLI', '', 'RAJESH', 1, 63, 5, 126, 56, '0', '', 'M', 'Y', 'N', 155, '2014-04-01', '2016-07-02', '208571', NULL),
(328, 470, 'E', 'D', 'Mr.', 'NANDKISHOR', 'BHIMRAO', 'DIWNALE', 1, 64, 5, 126, 52, '0', '', 'M', 'Y', 'N', 14, '2014-04-05', '2018-09-05', '444303', NULL),
(329, 17, 'E', 'D', 'Mr.', 'SAURABH', '', 'PRADHAN', 3, 31, 19, 420, 254, '0', 'saurabh.pradhan@vnrnursery.in', 'M', 'N', 'N', 102, '2014-04-07', '2015-08-06', '312000', NULL),
(330, 18, 'E', 'D', 'Mr.', 'SHIV', 'PRATAP ', 'SINGH', 3, 32, 19, 296, 254, '7415919877', 'shivpratap.singh@vnrnusery.in', 'M', 'N', 'N', 102, '2014-04-07', '2015-03-31', '206400', NULL),
(331, 471, 'E', 'D', 'Mr.', 'NISHITH', 'RANJAN', 'PARIDA', 1, 74, 12, 470, 51, '9589323578', 'nishith.parida@vnrseeds.com', 'M', 'Y', 'N', 1, '2014-04-18', '2018-12-08', '3799166', NULL),
(332, 472, 'E', 'A', 'Mr.', 'AJAY', 'KUMAR', 'SINGH', 1, 65, 6, 255, 449, '7318233101', 'ajayk.singh@vnrseeds.com', 'M', 'Y', 'N', 39, '2014-05-02', NULL, '454926', NULL),
(333, 473, 'E', 'D', 'Mr.', 'POTLA', '', 'SATYANARAYANA', 1, 63, 6, 254, 79, '7032920330', 'Psatyanarayana.vnr@gmail.com', 'M', 'Y', 'N', 124, '2014-05-12', '2018-03-01', '354756', NULL),
(334, 474, 'E', 'D', 'Dr.', 'VIPIN', 'CHANDRA ', 'JOSHI', 1, 67, 24, 359, 263, '0', 'vcjoshi.vnr@gmail.com', 'M', 'N', 'Y', 14, '2014-05-17', '2017-04-29', '501164', NULL),
(335, 475, 'E', 'A', 'Mr.', 'ANIL', 'KUMAR', 'MANIKPURI', 1, 64, 5, 55, 52, '9575507728', 'manikpurianilkumar@gmail.com', 'M', 'N', 'N', 14, '2014-05-21', NULL, '426035', NULL),
(336, 476, 'E', 'D', 'Mr.', 'VINOD', 'KUMAR', 'GANGWAR', 1, 64, 25, 431, 195, '7898595329', 'vgangwar.vnr@gmail.com', 'M', 'Y', 'N', 118, '2014-06-02', '2016-01-11', '180040', NULL),
(337, 477, 'E', 'D', 'Mr.', 'MANOJ', '', 'SINGH', 1, 62, 6, 256, 62, '7544001834', '', 'M', 'N', 'N', 165, '2014-06-02', '2016-01-17', '200529', NULL),
(338, 478, 'E', 'A', 'Mr.', 'RAJ', '', 'KUMAR', 1, 66, 6, 68, 261, '7544001836', 'rajkumar.vspl@gmail.com', 'M', 'Y', 'N', 73, '2014-06-02', NULL, '713806', NULL),
(339, 479, 'E', 'D', 'Mr.', 'MD', '', 'SHAFI', 1, 63, 6, 254, 220, '9948178883', 'md.shafi@vnrseeds.com', 'M', 'Y', 'N', 126, '2014-06-02', '2018-05-31', '327458', NULL),
(340, 480, 'E', 'A', 'Mr.', 'SURENDRA', 'KUMAR', 'GUPTA', 1, 62, 4, 225, 694, '9407705763', 'surendra.gupta@vnrseeds.in', 'M', 'Y', 'N', 66, '2014-06-05', NULL, '239032', NULL),
(341, 481, 'E', 'D', 'Ms.', 'MANOSMITA ', '', 'MISHRA', 1, 64, 12, 347, 97, '9179042145', '', 'F', 'N', 'N', 1, '2014-07-01', '2016-12-10', '306988', NULL),
(343, 482, 'E', 'D', 'Mr.', 'ABHISHEK ', '', 'MISHRA', 1, 67, 2, 5, 89, '0', '', 'M', 'N', 'N', 7, '2014-07-15', '2016-02-19', '408008', NULL),
(344, 483, 'E', 'D', 'Mr.', 'HARSHAL', '', 'MISHRA', 1, 67, 3, 214, 502, '0', 'harshal.mishra@vnrseeds.com', 'M', 'N', 'N', 2, '2014-07-15', '2017-08-19', '521486', NULL),
(345, 484, 'E', 'A', 'Mr.', 'MANISH ', '', 'BHANWARIYA', 1, 69, 2, 3, 89, '9694634842', 'manish.bhanwariya@vnrseeds.com', 'M', 'Y', 'N', 1, '2014-07-15', NULL, '1164992', NULL),
(346, 485, 'E', 'D', 'Mr.', 'A', '', 'ESWARAN', 1, 62, 6, 256, 79, '0', '', 'M', 'N', 'N', 127, '2014-07-22', '2014-11-05', '258252', NULL),
(347, 486, 'E', 'D', 'Mr.', 'SUDHEER', '', 'SINGH', 1, 68, 2, 3, 108, '8897812962', 'sudheer.singh@vnrseeds.com', 'M', 'N', 'N', 12, '2014-07-25', '2020-05-22', '741892', NULL),
(348, 487, 'E', 'D', 'Mr.', 'KISHORE', '', 'DEBBARMA', 1, 61, 11, 432, 89, '0', '', 'M', 'N', 'N', 7, '2014-08-01', '2018-02-07', '221052', NULL),
(349, 488, 'E', 'A', 'Mr.', 'NARSANOLLA', '', 'RAMESH', 1, 63, 2, 131, 108, '9951951919', 'narsanolla.ramesh@gmail.com', 'M', 'Y', 'N', 7, '2014-08-01', NULL, '388235', NULL),
(350, 489, 'E', 'D', 'Mr.', 'K', 'RAMAKRISHNA', 'REDDY', 1, 61, 2, 307, 283, '0', '', 'M', 'N', 'N', 7, '2014-08-01', '2015-05-30', '103110', NULL),
(351, 490, 'E', 'D', 'Mr.', 'VIPUL', '', 'KUMAR', 1, 62, 3, 287, 321, '0', '', 'M', 'Y', 'N', 128, '2014-08-19', '2015-12-22', '172830', NULL),
(352, 491, 'E', 'A', 'Mr.', 'BHUWANESH', '', 'PATEL', 1, 66, 8, 191, 109, '7509000759', 'bpatel.vspl@gmail.com', 'M', 'Y', 'N', 1, '2014-09-01', NULL, '697362', NULL),
(353, 492, 'E', 'D', 'Mr.', 'PANKAJ', 'BHILA', 'PAGAR', 1, 64, 3, 285, 321, '0', '', 'M', 'Y', 'N', 46, '2014-09-01', '2016-08-31', '305319', NULL),
(354, 493, 'E', 'A', 'Mr.', 'RAHUL', '', 'PATIDAR', 1, 67, 27, 481, 52, '8238767222', 'rahul.patidar@vnrseeds.in', 'M', 'Y', 'N', 14, '2014-09-22', NULL, '1030959', NULL),
(355, 494, 'E', 'D', 'Mr.', 'SYED HASEEBUDDIN', '', 'SYED MUJEEBUDDIN', 1, 64, 4, 306, 360, '7032317772', '', 'M', 'N', 'N', 22, '2014-09-22', '2016-01-23', '163950', NULL),
(356, 495, 'E', 'D', 'Mr.', 'RAM', 'SUNDER', 'CHAUDHARY', 1, 64, 4, 306, 145, '9792071970', 'ramsunder.vnr@gmail.com', 'M', 'N', 'N', 129, '2014-09-26', '2020-02-16', '389027', NULL),
(357, 496, 'E', 'D', 'Mr.', 'NITIN', '', 'CHAUDHARY', 1, 64, 4, 306, 433, '0', '', 'M', 'N', 'N', 84, '2014-09-27', '2016-02-09', '268539', NULL),
(358, 497, 'E', 'D', 'Mr.', 'RAM', 'PRAKASH ', 'SINGH', 1, 64, 6, 257, 241, '7544007774', '', 'M', 'Y', 'N', 3, '2014-10-01', '2016-06-30', '300198', NULL),
(359, 498, 'E', 'A', 'Mr.', 'RAJESH', 'KUMAR', 'SINGH', 1, 70, 4, 427, 35, '8959590915', 'rajesh.singh@vnrseeds.com', 'M', 'Y', 'N', 130, '2014-10-01', NULL, '1671598', NULL),
(360, 499, 'E', 'D', 'Mr.', 'K', 'RAJU', 'NAYAK', 1, 69, 4, 371, 362, '9542641737', 'kraju.nayak@vnrseeds.com', 'M', 'Y', 'N', 22, '2014-10-09', '2019-11-20', '1107032', NULL),
(361, 500, 'E', 'A', 'Mr.', 'ANUP', 'KUMAR ', 'CHAKRABORTY', 1, 68, 25, 221, 195, '9617019051', 'ch.anup@vnrseeds.com', 'M', 'Y', 'N', 131, '2014-10-20', NULL, '772198', NULL),
(362, 501, 'E', 'A', 'Mr.', 'VINOD', '', 'KUMAR', 1, 71, 4, 370, 35, '9000350001', 'vinod.kumar@vnrseeds.com', 'M', 'Y', 'N', 22, '2014-10-29', NULL, '3522800', NULL),
(363, 502, 'E', 'A', 'Mr.', 'PRAKASH', 'VIKRAM ', 'SABLE', 1, 65, 4, 306, 433, '9975498662', 'prakashvnr10@gmail.com', 'M', 'Y', 'N', 84, '2014-11-10', NULL, '384755', NULL),
(364, 503, 'E', 'D', 'Mr.', 'SAGAR', 'GANESH', 'BORSE', 1, 63, 6, 254, 431, '9326814195', '', 'M', 'Y', 'N', 133, '2014-12-03', '2016-10-18', '354750', NULL),
(365, 504, 'E', 'D', 'Mr.', 'JAGDISH ', 'PRASAD', 'YADUVANSHI', 1, 63, 6, 254, 550, '7727866624', 'jadish.y@vnrseeds.com', 'M', 'Y', 'N', 134, '2014-12-08', '2018-06-10', '301058', NULL),
(366, 505, 'E', 'A', 'Mr.', 'ARJUN', 'KUMAR', 'VERMA', 1, 67, 25, 437, 195, '9993133872', 'arjunk.verma@vnrseeds.com', 'M', 'Y', 'N', 9, '2014-12-23', NULL, '623005', NULL),
(367, 506, 'E', 'D', 'Mr.', 'ANIL ', 'KUMAR', 'SINGH', 1, 64, 3, 285, 15, '0', 'anilk.singh@vnrseeds.com', 'M', 'Y', 'N', 10, '2015-01-02', '2015-10-10', '245834', NULL),
(368, 507, 'E', 'D', 'Mr.', 'NISHU', '', 'KUMAR', 1, 65, 4, 306, 821, '9412831548', 'nishudeol007@gmail.com', 'M', 'N', 'N', 22, '2015-01-02', '2019-12-06', '435871', NULL),
(369, 509, 'E', 'D', 'Mr.', 'SHAIK', 'ABDUL RAHMAN', 'ASAD', 1, 65, 4, 306, 362, '9603409961', '', 'M', 'Y', 'N', 22, '2015-01-02', '2018-01-03', '299932', NULL),
(370, 510, 'E', 'A', 'Mr.', 'K ', 'BIPIN', 'KUMAR', 1, 70, 6, 66, 531, '9789376598', 'k.bipin@vnrseeds.com', 'M', 'Y', 'N', 135, '2015-01-05', NULL, '1894755', NULL),
(371, 511, 'E', 'D', 'Mr.', 'LAVKUSH', 'PRASAD', 'PATEL', 1, 64, 6, 257, 308, '0', 'lp.patel@vnrseeds.com', 'M', 'Y', 'N', 80, '2015-01-12', '2016-04-09', '462458', NULL),
(372, 508, 'E', 'D', 'Mr.', 'JITENDRA', '', 'KUMAR', 1, 64, 4, 306, 362, '7348235131', 'jitubhu10@gmail.com', 'M', 'N', 'N', 22, '2015-01-02', '2016-02-06', '267535', NULL),
(373, 512, 'E', 'D', 'Mr.', 'V', 'VINOD', 'KUMAR', 1, 63, 5, 126, 56, '0', '', 'M', 'N', 'N', 155, '2015-02-09', '2017-01-04', '281962', NULL),
(374, 513, 'E', 'D', 'Mr.', 'BIBHU', 'PRASAD', 'MISHRA', 1, 65, 6, 255, 375, '9437636737', 'bp.mishra@vnrseeds.com', 'M', 'N', 'N', 202, '2015-02-16', '2018-03-30', '361930', NULL),
(375, 514, 'E', 'A', 'Mr.', 'CHANDAN', '', 'PATRA', 1, 71, 6, 66, 140, '9938512125', 'chandan.patra@vnrseeds.com', 'M', 'Y', 'N', 34, '2015-02-16', NULL, '2033010', NULL),
(376, 515, 'E', 'D', 'Mr.', 'SANTOSH', 'KUMAR', 'PATEL', 1, 64, 6, 257, 241, '0', 'santoshpatel.vnr@gmail.com', 'M', 'N', 'N', 137, '2015-02-25', '2016-10-28', '274967', NULL),
(377, 516, 'E', 'A', 'Mr.', 'MANISH', '', 'SINGH', 1, 67, 4, 372, 145, '8318335360', 'manishsinghvnr@gmail.com', 'M', 'N', 'N', 129, '2015-03-10', NULL, '673205', NULL),
(378, 517, 'E', 'A', 'Mr.', 'RAKESH', 'KUMAR', 'PAL', 1, 65, 2, 7, 601, '8518925240', 'rakeshrdvnr@gmail.com', 'M', 'Y', 'N', 196, '2015-03-13', NULL, '414355', NULL),
(379, 518, 'E', 'A', 'Mr.', 'TAMESHWAR', '', 'THAKRE', 1, 66, 6, 68, 14, '8435368126', 'tameshwarthakre.vnr@gmail.com', 'M', 'Y', 'N', 181, '2015-03-14', NULL, '775876', NULL),
(380, 519, 'E', 'D', 'Mr.', 'BHAGIRATH', 'LAL', 'MEENA', 1, 63, 6, 254, 86, '9799998036', '', 'M', 'Y', 'N', 141, '2015-03-17', '2016-09-30', '163179', NULL),
(381, 520, 'E', 'A', 'Mr.', 'HEERALAL ', '', 'YADAV', 1, 63, 24, 39, 263, '9907345109', 'qc.vspl@vnrseeds.com', 'M', 'Y', 'N', 14, '2015-03-23', NULL, '320063', NULL),
(382, 521, 'E', 'A', 'Mr.', 'DINESH', 'KUMAR', 'PANDEY', 1, 69, 24, 551, 263, '9589333029', 'dinesh.vspl@gmail.com', 'M', 'N', 'N', 14, '2015-03-23', NULL, '935000', NULL),
(383, 522, 'E', 'D', 'Mr.', 'HANUMAN', 'SAHAY', 'GURJAR', 1, 63, 6, 254, 86, '9799995094', 'hanuman.sahay986@gmail.com', 'M', 'Y', 'N', 128, '2015-03-25', '2017-06-21', '212692', NULL),
(384, 523, 'E', 'D', 'Ms.', 'SAKSHI', '', 'CHAUHAN', 1, 67, 8, 112, 110, '0', 'sakshi.chauhan@vnrseeds.com', 'F', 'N', 'N', 1, '2015-03-26', '2018-10-16', '378003', NULL),
(385, 524, 'E', 'D', 'Mr.', 'UDAYVEER', '', 'SINGH', 1, 64, 4, 169, 362, '9983724451', 'udaykuntalgold@gmail.com', 'M', 'Y', 'N', 22, '2015-03-27', '2016-01-04', '214230', NULL),
(386, 525, 'E', 'A', 'Mr.', 'PITAMBER', '', 'LAL', 1, 66, 8, 83, 109, '9755938688', 'pitamber.lal@vnrseeds.in', 'M', 'Y', 'N', 1, '2015-04-01', NULL, '583610', NULL),
(387, 526, 'E', 'A', 'Mr.', 'ARUN ', 'KUMAR', 'EITAVDIA', 1, 66, 4, 373, 433, '7741062718', 'arunvnr26@gmail.com', 'M', 'Y', 'N', 84, '2015-04-01', NULL, '648825', NULL),
(388, 527, 'E', 'D', 'Mr.', 'SUBHASH ', 'KUMAR', 'BHARGAV', 1, 64, 4, 169, 362, '0', '', 'M', 'Y', 'N', 22, '2015-04-01', '2015-04-04', '199110', NULL),
(389, 528, 'E', 'D', 'Mr.', 'SHEKHAR', 'KUMAR', 'ETAVADIYA', 1, 64, 4, 169, 362, '0', '', 'M', 'N', 'N', 22, '2015-04-01', '2015-05-23', '236522', NULL),
(390, 529, 'E', 'D', 'Mr.', 'MANISH', '', 'DOIPHODE', 1, 63, 8, 193, 109, '0', '', 'M', 'Y', 'N', 1, '2015-04-06', '2015-04-20', '223715', NULL),
(391, 530, 'E', 'A', 'Mr.', 'MANOJ ', 'KUMAR', 'PARICHHA', 1, 62, 27, 482, 279, '9032839028', 'jhunumaparichha@gmail.com', 'M', 'Y', 'N', 22, '2015-04-08', NULL, '283683', NULL),
(392, 531, 'E', 'D', 'Mr.', 'AMIT ', '', 'KUMAR', 1, 72, 6, 474, 51, '9792692777', 'amit.kumar@vnrseeds.com', 'M', 'Y', 'N', 1, '2015-05-02', NULL, '2845256', NULL),
(393, 534, 'E', 'A', 'Mr.', 'D', '', 'SARAVANAN', 1, 65, 6, 255, 370, '9751413082', 'vnr.saravanan1989@gmail.com', 'M', 'Y', 'N', 127, '2015-05-12', NULL, '633501', NULL),
(394, 532, 'E', 'D', 'Mr.', 'GURPREET', '', 'SINGH', 1, 66, 6, 68, 11, '0', '', 'M', 'N', 'N', 119, '2015-05-05', '2015-05-09', '0', NULL),
(395, 533, 'E', 'D', 'Mr.', 'RAHUL', '', 'SHARMA', 1, 61, 6, 174, 11, '0', '', 'M', 'Y', 'N', 151, '2015-05-05', '2015-08-13', '171750', NULL),
(396, 535, 'E', 'D', 'Mr.', ' K. ', 'SENTHIL', 'KUMAR', 1, 64, 6, 257, 370, '9750604600', 'ksenthil1988@gmail.com', 'M', 'Y', 'N', 153, '2015-06-01', '2021-07-12', '416143', NULL),
(397, 536, 'E', 'D', 'Mr.', 'BHAGWAN ', '', 'INGLE', 1, 63, 6, 254, 533, '7057202297', 'bhagwaningle123@gmail.com', 'M', 'Y', 'N', 57, '2015-06-01', '2017-10-14', '229732', NULL),
(398, 537, 'E', 'D', 'Mr.', 'DEEPAK', '', 'CHATURVEDI', 1, 64, 6, 257, 34, '9427531681', '', 'M', 'Y', 'N', 38, '2015-06-01', '2015-10-06', '300898', NULL),
(399, 538, 'E', 'A', 'Mr.', 'RISHAV', '', 'RANJAN', 1, 72, 6, 65, 140, '9935700050', 'rishav.ranjan@vnrseeds.com', 'M', 'Y', 'N', 206, '2015-06-02', NULL, '2689373', NULL),
(400, 539, 'E', 'D', 'Mr.', 'AMOL', 'VIJAYRAO', 'SHAHADE', 1, 63, 6, 254, 57, '7767872929', '', 'M', 'N', 'N', 57, '2015-06-22', '2016-04-09', '273534', NULL),
(401, 540, 'E', 'A', 'Mr.', 'GAJENDRA ', '', 'SINGH', 1, 66, 6, 68, 34, '7874826889', 'gajendra.vnrseeds@gmail.com', 'M', 'Y', 'N', 132, '2015-07-01', NULL, '807640', NULL),
(402, 541, 'E', 'A', 'Mr.', 'RAJNISH', '', 'KESTWAL', 1, 65, 6, 255, 438, '9045604321', 'rajnish.k@vnrseeds.com', 'M', 'Y', 'N', 81, '2015-07-01', NULL, '564637', NULL),
(403, 542, 'E', 'D', 'Mr.', 'DIWAKAR ', 'SINGH ', 'BHADAURIA', 1, 64, 6, 257, 399, '9450283789', 'diwakar.singh@vnrseeds.com', 'M', 'Y', 'N', 205, '2015-07-01', '2018-11-30', '324458', NULL),
(404, 543, 'E', 'A', 'Mr.', 'GAURAV', '', 'RATHOD', 1, 64, 8, 193, 109, '8103730400', 'gaurav.vspl@gmail.com', 'M', 'Y', 'N', 1, '2015-07-13', NULL, '317963', NULL),
(405, 544, 'E', 'A', 'Mr.', 'NAVDEEP', '', 'SINGH', 1, 65, 6, 255, 11, '8872782018', 'navdeep.singh@vnrseeds.com', 'M', 'N', 'N', 119, '2015-08-01', NULL, '501879', NULL),
(406, 545, 'E', 'A', 'Mr.', 'MOHD', '', 'NAFIS', 1, 65, 7, 208, 28, '9584130484', 'nafis.vnr@gmail.com', 'M', 'Y', 'N', 1, '2015-08-26', NULL, '446667', NULL),
(407, 546, 'E', 'D', 'Mr.', 'SMRUTI ', 'SANAT', 'ACHARYA', 1, 64, 6, 257, 241, '0', '', 'M', 'N', 'N', 161, '2015-09-02', '2017-01-14', '301373', NULL),
(408, 547, 'E', 'D', 'Mr.', 'PRIYABRATA ', '', 'DASH', 1, 64, 12, 347, 331, '0', 'priyabrata.dash@vnrseeds.com', 'M', 'N', 'N', 1, '2015-09-02', '2017-09-26', '316936', NULL),
(409, 548, 'E', 'D', 'Mr.', 'PRABHAT', 'KUMAR', 'KUNDU', 1, 66, 6, 68, 375, '8328800846', 'prabhatkundu.vnr@gmail.com', 'M', 'Y', 'N', 393, '2015-09-02', '2021-01-10', '591659', NULL),
(410, 19, 'E', 'A', 'Mr.', 'RANDIP', '', 'GHOSH', 3, 32, 21, 621, 727, '8819090075', 'randip.ghosh@vnrnursery.in', 'M', 'N', 'N', 103, '2015-08-21', NULL, '693987', NULL),
(411, 20, 'E', 'D', 'Ms.', 'TWINKLE', '', 'SINGH', 3, 31, 21, 412, 260, '0', 'twinkle.singh@vnrnursery.in', 'F', 'N', 'N', 103, '2015-08-21', NULL, '471728', NULL),
(412, 549, 'E', 'D', 'Mr.', 'KALPESH', 'B', 'VASOYA', 1, 66, 6, 68, 14, '0', 'kalpeshb.vasoya@gmail.com', 'M', 'Y', 'N', 123, '2015-09-02', '2019-03-04', '614440', NULL),
(413, 550, 'E', 'D', 'Mr.', 'DEVENDRA', '', 'TIWARI', 1, 64, 6, 257, 550, '7568992821', 'devendra.tiwarivnr@gmail.com', 'M', 'Y', 'N', 114, '2015-09-14', '2018-03-20', '294461', NULL),
(414, 551, 'E', 'A', 'Mr.', 'ANUJ', '', 'KUMAR', 1, 69, 2, 3, 89, '9412196885', 'anuj.kumar@vnrseeds.com', 'M', 'N', 'N', 1, '2015-09-15', NULL, '982174', NULL),
(415, 552, 'E', 'D', 'Mr.', 'YASH', 'PAL', 'SINGH', 1, 66, 6, 68, 399, '9045114045', 'yashpal.vnrseeds@gmail.com', 'M', 'Y', 'N', 2, '2015-09-16', '2018-09-20', '619822', NULL),
(416, 553, 'E', 'A', 'Mr.', 'BABALU ', 'KUMAR', 'PATEL', 1, 66, 25, 437, 195, '8085428257', 'bablu.patel@vnrseeds.com', 'M', 'Y', 'N', 9, '2015-09-17', NULL, '443853', NULL),
(417, 554, 'E', 'A', 'Dr.', 'ASHOK', 'KUMAR ', 'GUPTA', 1, 73, 12, 486, 51, '9833104933', 'ashok.kumar@vnrseeds.com', 'M', 'Y', 'Y', 1, '2015-09-23', NULL, '3675232', NULL),
(418, 555, 'E', 'D', 'Mr.', 'KIRAN', ' KUMAR', 'DHANARAJ', 1, 63, 6, 254, 514, '0', '', 'M', 'N', 'N', 163, '2015-10-01', '2018-05-07', '323858', NULL),
(419, 556, 'E', 'A', 'Mr.', 'VIKAS', '', 'PANDEY', 1, 67, 6, 415, 399, '9565323456', 'vikaspandey.vnrseeds@gmail.com', 'M', 'Y', 'N', 45, '2015-10-06', NULL, '905199', NULL),
(420, 557, 'E', 'D', 'Mrs.', 'BHUMIKA', '', 'BONDRE', 1, 65, 1, 198, 142, '0', 'bhumika.bondre@vnrseeds.com', 'F', 'Y', 'N', 1, '2015-10-06', '2018-09-07', '348218', NULL),
(421, 558, 'E', 'A', 'Mr.', 'DEEPAK ', 'KUMAR', 'SAHU', 1, 66, 8, 191, 110, '7828430003', 'deepak.sahu@vnrseeds.com', 'M', 'Y', 'N', 1, '2015-10-06', NULL, '516085', NULL),
(422, 560, 'E', 'A', 'Mr.', 'RAM', 'PRAKASH', 'SINGH', 1, 65, 6, 255, 11, '9697549419', 'ramprakashsingh.vnr@gmail.com', 'M', 'Y', 'N', 151, '2015-11-03', NULL, '570855', NULL),
(423, 561, 'E', 'D', 'Mr.', 'RAJEEV', '', 'SINGH', 1, 63, 6, 254, 11, '9646800519', 'rajeevsinghvnrseeds@gmail.com', 'M', 'Y', 'N', 164, '2015-11-03', '2019-12-05', '341258', NULL),
(424, 562, 'E', 'D', 'Mr.', 'MOTAKULE ', 'SHRIRAM ', 'DATTATRAY', 1, 64, 4, 169, 145, '7757868079', '', 'M', 'N', 'N', 129, '2015-11-05', '2016-01-25', '197490', NULL),
(425, 559, 'E', 'D', 'Mr.', 'RAMBRAJ', '', '', 1, 63, 6, 254, 34, '9098351819', 'rambraj85@gmail.com', 'M', 'Y', 'N', 167, '2015-11-02', '2018-03-31', '239404', NULL),
(426, 21, 'E', 'D', 'Mr.', 'ASHISH', '', '', 3, 32, 19, 419, 254, '0', 'ashish.sajwan@vnrnursery.in', 'M', 'N', 'N', 102, '2015-10-23', NULL, '540062', NULL),
(427, 563, 'E', 'D', 'Mr.', 'VILAS ', 'GANPAT', 'JADHAV', 1, 65, 24, 237, 263, '0', 'vilasjadhavpatil@gmail.com', 'M', 'Y', 'N', 155, '2015-11-16', '2017-10-17', '414584', NULL),
(428, 564, 'E', 'D', 'Mr.', 'MANOJ', 'TRYAMBAK', 'SAVAKARE', 1, 64, 6, 257, 431, '0', '', 'M', 'Y', 'N', 166, '2015-11-17', '2017-02-15', '360133', NULL),
(429, 565, 'E', 'D', 'Mr.', 'RAJIV', '', 'RAGHUWANSHI', 1, 65, 6, 255, 14, '7211109933', 'rajivraghu1c@gmail.com', 'M', 'Y', 'N', 168, '2015-11-19', '2018-02-10', '466302', NULL),
(430, 566, 'E', 'D', 'Mr.', 'KUMBHANI', 'JITENDRA', 'C', 1, 65, 6, 255, 14, '0', 'jitendrackumbhani@gmail.com', 'M', 'Y', 'N', 169, '2015-11-21', '2019-01-31', '402034', NULL),
(431, 567, 'E', 'D', 'Mr.', 'SANTOSH', '', 'SINGH', 1, 69, 6, 67, 417, '0', 'santoshk.singh@vnrseeds.com', 'M', 'Y', 'N', 46, '2015-12-01', '2019-01-15', '1143499', NULL),
(432, 568, 'E', 'D', 'Mr.', 'BRIJESH ', 'KUMAR', 'GUPTA', 1, 65, 24, 237, 263, '0', 'brijesh.gupta@vnrseeds.com', 'M', 'Y', 'N', 14, '2015-12-07', '2018-06-20', '314858', NULL),
(433, 569, 'E', 'A', 'Mr.', 'RAVINDRA ', 'PAL', 'SINGH', 1, 71, 4, 370, 263, '7083266596', 'ravindrap.singh@vnrseeds.com', 'M', 'Y', 'N', 84, '2015-12-08', NULL, '2692529', NULL),
(434, 570, 'E', 'D', 'Mr.', 'ANIL ', 'CHANDRABHAN ', 'KUBADE', 1, 65, 4, 306, 360, '9701696490', 'kubade.anil52@gmail.com', 'M', 'Y', 'N', 22, '2015-12-14', '2017-09-02', '307738', NULL),
(435, 571, 'E', 'D', 'Mr.', 'SAMANT ', '', 'KUMAR', 1, 65, 12, 348, 331, '0', '', 'M', 'N', 'N', 1, '2015-12-14', '2016-02-12', '591426', NULL),
(436, 572, 'E', 'D', 'Mr.', 'PRATEESH', 'KUMAR', 'MISHRA', 1, 66, 24, 239, 382, '9450769831', 'mishraprateeshkumar38@gmail.com', 'M', 'Y', 'N', 14, '2015-12-15', '2020-12-18', '464795', NULL),
(437, 573, 'E', 'D', 'Mr.', 'SUSHIL', '', 'MEHRA', 1, 66, 24, 239, 382, '9584027511', 'sam.sushilmehra1987@gmail.com', 'M', 'Y', 'N', 14, '2015-12-21', '2020-10-08', '21600', NULL),
(438, 574, 'E', 'A', 'Mr.', 'DEEPAK', '', 'MEHRA', 1, 72, 6, 65, 140, '9855552457', 'deepak.mehra@vnrseeds.com', 'M', 'Y', 'N', 95, '2015-12-21', NULL, '2231739', NULL),
(439, 575, 'E', 'D', 'Mr.', 'BATTEWADA', 'PRAVEEN', 'KUMAR', 1, 66, 5, 461, 56, '0', 'bpraveen.vnrseeds@gmail.com', 'M', 'Y', 'N', 155, '2016-01-02', '2018-12-31', '486817', NULL),
(440, 576, 'E', 'D', 'Dr.', 'CHETANKUMAR', '', 'BANAKAR', 1, 67, 2, 5, 89, '9109006162', 'chetan.kumar@vnrseeds.com', 'M', 'N', 'Y', 15, '2016-01-15', '2017-04-08', '649787', NULL),
(441, 577, 'E', 'A', 'Mr.', 'ASUTOSH ', '', 'NAYAK', 1, 66, 6, 68, 375, '7504736300', 'nayakasutosh77.vnrseeds@gmail.com', 'M', 'N', 'N', 202, '2016-01-25', NULL, '691036', NULL),
(442, 578, 'E', 'D', 'Mr.', 'SIRSAK ', 'SEKHAR', 'PANDA', 1, 65, 6, 255, 375, '9083257535', 'sirsakpanda.vnrseeds@gmail.com', 'M', 'N', 'N', 121, '2016-01-25', '2019-04-10', '486506', NULL),
(443, 579, 'E', 'D', 'Mr.', 'ANSHUMAN', '', 'SINGH', 1, 63, 6, 286, 308, '0', '', 'M', 'N', 'N', 64, '2016-01-25', '2016-12-05', '264727', NULL),
(444, 580, 'E', 'D', 'Dr.', 'VIVEK', 'KUMAR', 'SINGH', 1, 67, 2, 439, 65, '0', 'vivek.singh@vnrseeds.com', 'M', 'Y', 'Y', 1, '2016-02-08', '2017-07-15', '447114', NULL),
(445, 22, 'E', 'A', 'Mr.', 'SAURABH ', '', 'PRADHAN', 3, 33, 19, 622, 254, '0', 'saurabh.pradhan@vnrnursery.in', 'M', 'Y', 'N', 102, '2016-01-11', NULL, '827815', NULL),
(446, 581, 'E', 'A', 'Mr.', 'DATTUKANT ', 'GANGADHAR', 'CHAPLE', 1, 66, 5, 463, 56, '9640705955', 'dattukant.vnrseeds@gmail.com', 'M', 'Y', 'N', 155, '2016-02-16', NULL, '645488', NULL),
(447, 582, 'E', 'D', 'Mr.', 'MANOJ', '', 'KUMAR', 1, 66, 6, 68, 551, '0', 'manojkulkarni.vnrseeds@gmail.com', 'M', 'Y', 'N', 178, '2016-02-22', '2018-06-15', '591446', NULL),
(448, 583, 'E', 'A', 'Mr.', 'VED', 'PRAKASH', 'MAURYA', 1, 65, 4, 306, 73, '9412656381', 'vedprakash.vnrseeds@gmail.com', 'M', 'N', 'N', 90, '2016-02-24', NULL, '461819', NULL),
(449, 585, 'E', 'A', 'Mr.', 'RAMESH', 'SINGH', 'KUNJWAL', 1, 71, 6, 66, 438, '9704711175', 'ramesh.singh.kunjwal@vnrseeds.com', 'M', 'N', 'N', 4, '2016-03-03', NULL, '1780273', NULL),
(450, 584, 'E', 'A', 'Mr.', 'MAHENDRA ', 'SINGH', 'SISODIYA', 1, 66, 6, 68, 924, '9993701655', 'msisodiya79@gmail.com', 'M', 'Y', 'N', 38, '2016-03-03', NULL, '686305', NULL),
(451, 586, 'E', 'D', 'Mr.', 'ASHISH', '', 'KUMAR', 1, 64, 3, 285, 321, '0', 'ashishkumar.vnrseeds@gmail.com', 'M', 'Y', 'N', 23, '2016-03-08', '2018-09-27', '310418', NULL),
(452, 587, 'E', 'D', 'Mr.', 'DIRAL', 'N', 'SHARMA', 1, 64, 6, 257, 14, '9427814461', 'diral.sharma.vnrseeds@gmail.com', 'M', 'Y', 'N', 42, '2016-03-21', '2017-04-30', '492822', NULL),
(453, 588, 'E', 'D', 'Mr.', 'AMIT', '', 'SINGH', 1, 63, 5, 119, 52, '8147523158', '', 'M', 'N', 'N', 14, '2016-03-22', '2016-05-02', '202931', NULL),
(454, 589, 'E', 'D', 'Mr.', 'CHARUDATTA', '', 'PANDE', 1, 65, 6, 255, 14, '9096953741', 'ck.vnrseed@gmail.com', 'M', 'Y', 'N', 140, '2016-03-28', '2021-04-30', '702455', NULL),
(455, 592, 'E', 'D', 'Mr.', 'DATTATRAY', 'NANASAHEB', 'PATIL', 1, 65, 6, 255, 431, '0', 'dattatraypatil.vspl@gmail.com', 'M', 'Y', 'N', 61, '2016-04-04', '2018-07-14', '574445', NULL),
(456, 591, 'E', 'D', 'Mr.', 'VIJAY', 'BHAN', 'SINGH', 1, 66, 6, 68, 4, '0', 'vijaybhan.vspl@gmail.com', 'M', 'Y', 'N', 39, '2016-04-02', '2018-03-31', '676205', NULL),
(457, 594, 'E', 'D', 'Mr.', 'SUBHASH ', '', 'KUMAR', 1, 64, 6, 257, 14, '0', '', 'M', 'Y', 'N', 71, '2016-04-08', '2016-07-07', '418429', NULL),
(458, 593, 'E', 'D', 'Dr.', 'SAMIR ', 'YADAORAO', 'DHURAI', 1, 67, 2, 5, 89, '0', 'samir.dhurai@vnrseeds.com', 'M', 'N', 'Y', 7, '2016-04-06', '2018-02-17', '513737', NULL),
(459, 595, 'E', 'A', 'Mr.', 'RAHUL', 'KUMAR ', 'SAHU', 1, 66, 12, 488, 97, '7351231231', 'rahulk.sahu@vnrseeds.com', 'M', 'Y', 'N', 1, '2016-04-18', NULL, '1123746', NULL),
(460, 596, 'E', 'D', 'Mr.', 'SRINIVAS ', 'REDDY', 'NANDIGAM', 1, 74, 3, 357, 51, '0', 'srinivas.reddy@vnrseeds.com', 'M', 'Y', 'N', 7, '2016-04-22', '2019-02-06', '3750358', NULL),
(461, 590, 'E', 'A', 'Mr.', 'ARVIND', 'KUMAR', 'AGRAWAL', 1, 77, 17, 110, 0, '9329570007', 'fd@vnrseeds.com', 'M', 'Y', 'N', 1, '2016-04-01', NULL, '73416215', NULL),
(462, 597, 'E', 'D', 'Dr.', 'JITENDRA', 'SUBHASH ', 'DAPKE', 1, 68, 2, 3, 89, '8264673367', 'jitendra.dapke@vnrseeds.in', 'M', 'Y', 'Y', 204, '2016-05-02', '2020-08-31', '942499', NULL),
(463, 598, 'E', 'A', 'Mr.', 'DAVID', '', '', 1, 66, 25, 437, 195, '8795137801', 'david.john@vnrseeds.com', 'M', 'N', 'N', 9, '2016-05-02', NULL, '403203', NULL),
(464, 601, 'E', 'D', 'Mr.', 'PUNESH', '', 'CHOUHAN', 1, 64, 6, 257, 140, '0', 'puneshchouhan.vspl@gmail.com', 'M', 'N', 'N', 80, '2016-05-11', '2018-04-17', '370664', NULL),
(465, 599, 'E', 'D', 'Ms.', 'MEGHA', '', 'SAO', 1, 63, 5, 127, 52, '0', 'meghasao.vspl@gmail.com', 'F', 'N', 'N', 14, '2016-05-02', '2018-05-03', '259965', NULL),
(466, 600, 'E', 'A', 'Mr.', 'PRASHANT ', 'KUMAR', 'DHANKAR', 1, 64, 5, 144, 52, '7828999620', 'dprashant.vnr@gmail.com', 'M', 'Y', 'N', 14, '2016-05-02', NULL, '303551', NULL),
(467, 602, 'E', 'D', 'Mr.', 'AMIT ', '', 'MOHANTY', 1, 65, 6, 255, 375, '9861765691', 'amitmohanty.vspl@gmail.com', 'M', 'N', 'N', 189, '2016-05-17', '2020-05-06', '478403', NULL),
(468, 603, 'E', 'A', 'Mr.', 'VARESH', '', 'TIWARI', 1, 65, 6, 255, 438, '9690076600', 'vareshtiwari.vspl@gmail.com', 'M', 'Y', 'N', 182, '2016-05-17', NULL, '607745', NULL),
(469, 604, 'E', 'A', 'Mr.', 'HARINDER', '', 'YADAV', 1, 66, 6, 68, 399, '9935940777', 'harinder.vnr@gmail.com', 'M', 'Y', 'N', 205, '2016-06-01', NULL, '646675', NULL),
(470, 605, 'E', 'D', 'Mr.', 'SITA', '', 'RAM', 1, 63, 4, 169, 35, '0', '', 'M', 'N', 'N', 22, '2016-06-13', '2016-10-17', '284335', NULL),
(471, 606, 'E', 'D', 'Mr.', 'SHUBHAM', '', '', 1, 67, 4, 228, 778, '9919188721', 'shubham.vspl@gmail.com', 'M', 'Y', 'N', 263, '2016-06-13', '2019-12-21', '625003', NULL),
(472, 607, 'E', 'D', 'Mr.', 'ARIJIT', '', 'DAS', 1, 68, 2, 250, 601, '9002208939', 'arijit.das@vnrseeds.com', 'M', 'Y', 'N', 1, '2016-06-13', '2020-10-29', '724999', NULL),
(473, 608, 'E', 'D', 'Mr.', 'PATHAN ', 'SHAHID', 'NIJAMUDDIN', 1, 65, 4, 306, 35, '0', 'shahidpathan.vspl@gmail.com', 'M', 'N', 'N', 22, '2016-06-13', '2019-08-19', '415323', NULL),
(474, 609, 'E', 'D', 'Mr.', 'VALA', 'ANIL KUMAR', 'ARJANBHAI', 1, 64, 4, 169, 35, '0', '', 'M', 'N', 'N', 22, '2016-06-13', '2016-07-11', '253322', NULL),
(475, 610, 'E', 'D', 'Mr.', 'SANDEEP', '', 'AICH', 1, 64, 5, 441, 246, '0', '', 'M', 'Y', 'N', 14, '2016-06-20', '2016-09-20', '224363', NULL),
(476, 611, 'E', 'D', 'Mr.', 'RAM', '', 'KUMAR', 1, 64, 24, 237, 263, '0', 'ramkumar.vspl@gmail.com', 'M', 'N', 'N', 14, '2016-07-01', '2018-09-26', '253680', NULL),
(477, 612, 'E', 'A', 'Mr.', 'PIYUSH', 'KUMAR', 'VERMA', 1, 63, 5, 57, 56, '8815240646', 'vermapiyush1991@gmail.com', 'M', 'Y', 'N', 155, '2016-07-12', NULL, '383555', NULL),
(478, 613, 'E', 'D', 'Mr.', 'BHARAT ', 'LAL', 'SAHU', 1, 65, 2, 260, 65, '0', '', 'M', 'N', 'N', 185, '2016-07-18', '2016-09-07', '217481', NULL),
(479, 614, 'E', 'A', 'Mr.', 'YOGESH', 'KUMAR', 'DEWANGAN', 1, 64, 7, 207, 28, '8818810121', 'yogeshdewangan.vspl@gmail.com', 'M', 'Y', 'N', 1, '2016-08-01', NULL, '369827', NULL),
(480, 615, 'E', 'D', 'Mr.', 'RAVINDRA', '', 'GOPALE', 1, 66, 6, 68, 913, '7588695410', 'ravindragopale.vspl@gmail.com', 'M', 'Y', 'N', 96, '2016-08-20', '2020-04-13', '854868', NULL),
(481, 616, 'E', 'D', 'Mr.', 'KUMAR', '', 'B', 1, 66, 3, 214, 238, '0', 'kumarb.vspl@gmail.com', 'M', 'Y', 'N', 115, '2016-08-22', '2018-07-18', '593158', NULL),
(482, 23, 'E', 'D', 'Mr.', 'VISHAL', '', 'KUMAR', 3, 31, 19, 411, 254, '0', '', 'M', 'N', 'N', 102, '2016-08-01', '2016-10-16', '306000', NULL),
(483, 617, 'E', 'D', 'Mr.', 'HARSHAL', 'ARUN', 'BORASE', 1, 64, 3, 285, 460, '0', '', 'M', 'N', 'N', 46, '2016-09-01', '2018-09-05', '312218', NULL),
(484, 618, 'E', 'D', 'Mr.', 'NARESH', '', 'SAINI', 1, 65, 3, 213, 321, '0', '', 'M', 'Y', 'N', 42, '2016-09-05', '2017-07-20', '480006', NULL),
(485, 619, 'E', 'D', 'Mr.', 'SUSHIL', 'KUMAR', 'VYAS', 1, 64, 6, 257, 86, '0', 'sushilvyas.vspl@gmail.com', 'M', 'Y', 'N', 190, '2016-09-26', '2017-01-02', '264500', NULL),
(486, 620, 'E', 'D', 'Mr.', 'ANUBHAV', '', 'SHARMA', 1, 65, 6, 255, 140, '8795305798', 'anubhavsharma.vspl@gmail.com', 'M', 'N', 'N', 31, '2016-10-01', '2018-04-30', '449423', NULL),
(487, 621, 'E', 'A', 'Mr.', 'S', '', 'VAITHILINGAM', 1, 65, 6, 255, 370, '9791468867', 'vaithiraja1990@gmail.com', 'M', 'Y', 'N', 192, '2016-10-04', NULL, '523323', NULL),
(488, 622, 'E', 'A', 'Mr.', 'KUMMARI', '', 'PANDURANGAM', 1, 62, 2, 249, 283, '9010019769', 'kummaripandurangam66@gmail.com', 'M', 'Y', 'N', 7, '2016-10-04', NULL, '266399', NULL),
(489, 623, 'E', 'D', 'Mr.', 'ANIL', 'DNYANDEO ', 'MULE', 1, 67, 6, 415, 726, '9657433919', 'anilmule.vspl@gmail.com', 'M', 'Y', 'N', 46, '2016-10-17', '2020-06-15', '769828', NULL),
(490, 625, 'E', 'A', 'Mr.', 'RAM', '', 'BAKIL', 1, 66, 6, 68, 438, '9872744973', 'rambakil.vspl@gmail.com', 'M', 'Y', 'N', 148, '2016-10-25', NULL, '864918', NULL),
(491, 624, 'E', 'A', 'Mr.', 'RAHUL', '', 'AGRAWAL', 1, 65, 25, 466, 195, '8839378252', 'rahulagrl.vspl@gmail.com', 'M', 'Y', 'N', 14, '2016-10-18', NULL, '702198', NULL),
(492, 626, 'E', 'A', 'Mr.', 'MADAN', 'RAMRAO', 'KHANZODE', 1, 67, 6, 415, 913, '9860047873', 'madankhanzode.vspl@gmail.com', 'M', 'Y', 'N', 28, '2016-11-25', NULL, '839486', NULL),
(493, 627, 'E', 'D', 'Mr.', 'SHIVAM              ', '', '', 1, 63, 6, 256, 14, '7096124444', '', 'M', 'N', 'N', 71, '2016-12-20', '2018-01-02', '223132', NULL),
(494, 628, 'E', 'D', 'Mr.', 'SUYOG', 'SUNIL', 'SHINDE', 1, 64, 6, 257, 531, '9879962993', '', 'M', 'Y', 'N', 133, '2016-12-20', '2019-08-31', '541246', NULL),
(495, 629, 'E', 'A', 'Mr.', 'NARAYAN', '', 'HARI', 1, 66, 6, 68, 726, '9624309992', 'narayanhari.vspl@gmail.com', 'M', 'Y', 'N', 27, '2016-12-28', NULL, '649587', NULL),
(496, 630, 'E', 'A', 'Mr.', 'GIRJESH ', '', 'PATIDAR', 1, 67, 6, 415, 912, '9893316262', 'girjeshpatidar.vspl@gmail.com', 'M', 'Y', 'N', 201, '2017-01-09', NULL, '943897', NULL),
(497, 631, 'E', 'A', 'Mr.', 'SUMIT ', '', 'SHARMA', 1, 66, 6, 68, 399, '9451600710', 'sumitsharma.vspl@gmail.com', 'M', 'Y', 'N', 30, '2017-01-09', NULL, '655350', NULL),
(498, 632, 'E', 'A', 'Mr.', 'PB', 'NAGABASI ', 'REDDY', 1, 64, 6, 257, 220, '9000880479', 'basireddy.vspl@gmail.com', 'M', 'Y', 'N', 69, '2017-01-16', NULL, '465555', NULL),
(499, 633, 'E', 'D', 'Mr.', 'SAMIR ', 'KUMAR', 'BEHERA', 1, 63, 6, 286, 375, '9776670086', 'samirbehera.vspl@gmail.com', 'M', 'N', 'N', 76, '2017-01-16', '2019-03-12', '309938', NULL),
(500, 634, 'E', 'D', 'Mr.', 'PRATIK', '', 'PANDA', 1, 64, 6, 257, 584, '0', 'pratikpanda.vspl@gmail.com', 'M', 'N', 'N', 64, '2017-01-16', '2019-05-25', '416913', NULL),
(501, 635, 'E', 'D', 'Mr.', 'GOPAL ', 'KRISHNA', 'PADHI', 1, 63, 6, 286, 375, '8763568444', 'gopalpadhi.vspl@gmail.com', 'M', 'N', 'N', 142, '2017-01-16', '2018-09-08', '309938', NULL),
(502, 636, 'E', 'D', 'Mr.', 'AMRESH', 'CHANDRA', 'CHOUDHARY', 1, 69, 3, 212, 460, '0', '', 'M', 'Y', 'N', 3, '2017-01-20', '2017-12-23', '1034645', NULL),
(503, 637, 'E', 'D', 'Mr.', 'KASOJU', '', 'RAVIKUMAR', 1, 65, 6, 255, 220, '9000595059', 'ravikumar.vspl@gmail.com', 'M', 'Y', 'N', 7, '2017-01-21', '2019-12-05', '482837', NULL),
(504, 638, 'E', 'D', 'Mr.', 'ROBIN', '', 'SINGH', 1, 70, 4, 371, 35, '9704537263', 'robin.singh@vnrseeds.com', 'M', 'Y', 'N', 22, '2017-02-17', '2019-09-12', '1375461', NULL),
(505, 639, 'E', 'A', 'Mr.', 'SANDESH', 'R', 'GOHIL', 1, 65, 4, 306, 73, '797593457', 'sandeshgohil.vspl@gmail.com', 'M', 'Y', 'N', 90, '2017-02-21', NULL, '461622', NULL),
(506, 640, 'E', 'D', 'Mr.', 'AJOY', '', 'SARKAR', 1, 66, 6, 68, 241, '0', '', 'M', 'Y', 'N', 137, '2017-02-27', '2017-04-30', '643513', NULL),
(507, 641, 'E', 'A', 'Mr.', 'RAJESH', '', 'TM', 1, 68, 2, 3, 108, '8639083899', 'rajesh.tm@vnrseeds.com', 'M', 'N', 'N', 7, '2017-03-01', NULL, '866294', NULL),
(508, 642, 'E', 'D', 'Mr.', 'ROHIT', 'KUMAR', 'SINGH', 1, 64, 3, 285, 15, '9174831514', 'rohitsinghindophil1993@gmail.com', 'M', 'N', 'N', 10, '2017-03-01', '2018-06-01', '341978', NULL),
(509, 643, 'E', 'D', 'Mr.', 'KRISHNAJI', '', 'JODAGE', 1, 67, 2, 5, 89, '0', 'krishnaji.jodage@vnrseeds.com', 'M', 'N', 'N', 7, '2017-03-08', '2018-05-31', '439183', NULL),
(510, 645, 'E', 'A', 'Mr.', 'AKASH', '', 'KUMAR', 1, 66, 6, 68, 912, '8077557856', 'akashkumar.vspl@gmail.com', 'M', 'Y', 'N', 395, '2017-03-17', NULL, '587616', NULL),
(511, 644, 'E', 'A', 'Mr.', 'PANKAJ', '', 'KUMAR', 1, 63, 5, 57, 56, '8756685874', 'pankajkumar.vspl@gmail.com', 'M', 'Y', 'N', 155, '2017-03-17', NULL, '349463', NULL),
(512, 646, 'E', 'D', 'Mr.', 'ASHUTOSH ', '', 'UPADHYAY', 1, 64, 6, 257, 241, '9839665200', 'ashuupadhyay.vspl@gmail.com', 'M', 'N', 'N', 3, '2017-04-01', '2018-05-12', '628872', NULL),
(513, 647, 'E', 'D', 'Mr.', 'LALIT', '', 'DANGI', 1, 64, 6, 257, 86, '0', 'lalitdangi.vspl@gmail.com', 'M', 'N', 'N', 113, '2017-04-10', '2017-11-03', '275932', NULL),
(514, 648, 'E', 'D', 'Mr.', 'UDAYAKUMAR', '', 'M', 1, 69, 6, 67, 531, '9632555226', '', 'M', 'Y', 'N', 86, '2017-04-15', '2018-06-09', '913561', NULL),
(515, 649, 'E', 'D', 'Mr.', 'DINESHA', 'M', 'CHIPLONKER', 1, 70, 2, 471, 89, '9686001147', 'dinesha.chiplonker@vnrseeds.com', 'M', 'Y', 'N', 204, '2017-04-15', '2020-02-26', '1739170', NULL),
(516, 650, 'E', 'D', 'Mr.', 'KIRAN', 'SANTOSH', 'PAWAR', 1, 66, 6, 68, 431, '9730313888', 'kiranpawar.vspl@gmail.com', 'M', 'Y', 'N', 79, '2017-04-15', '2018-07-14', '458906', NULL),
(517, 651, 'E', 'A', 'Mr.', 'PANKAJ', '', 'SHRIVASTAVA', 1, 68, 2, 439, 601, '9926173808', 'pankaj.shrivastava@vnrseeds.com', 'M', 'Y', 'N', 1, '2017-04-20', NULL, '648863', NULL),
(518, 652, 'E', 'D', 'Mr.', 'AMIT', '', 'KANNAUJIA', 1, 64, 6, 257, 34, '9455536713', 'mit36575@gmail.com', 'M', 'Y', 'N', 172, '2017-05-02', '2018-04-24', '416893', NULL),
(519, 653, 'E', 'D', 'Dr.', 'VIKAS', 'VASANTRAO', 'BARASKAR', 1, 67, 2, 5, 89, '9021734853', 'vikas.baraskar@vnrseeds.com', 'M', 'N', 'Y', 7, '2017-05-02', '2018-05-10', '431496', NULL),
(520, 654, 'E', 'A', 'Mr.', 'MANJUNATH', '', 'PALOTI', 1, 68, 2, 3, 89, '9590257008', 'manjunath.paloti@vnrseeds.com', 'M', 'N', 'N', 204, '2017-05-24', NULL, '843916', NULL),
(521, 655, 'E', 'D', 'Mr.', 'AJAY', 'KUMAR', 'TIWARI', 1, 65, 6, 255, 726, '8210389974', 'ajaytiwari.iabm@gmail.com', 'M', 'N', 'N', 137, '2017-06-01', '2019-05-31', '695798', NULL),
(522, 656, 'E', 'D', 'Mr.', 'DINESH', 'P', 'KELAR', 1, 66, 6, 68, 14, '9978691134', 'dineshkelar.vspl@gmail.com', 'M', 'Y', 'N', 42, '2017-06-01', '2018-07-20', '661162', NULL),
(523, 24, 'E', 'D', 'Mr.', 'ANOOP', '', 'NAGAR', 3, 31, 19, 410, 445, '0', 'anoop.nagar@vnrnursery.in', 'M', 'N', 'N', 102, '2017-06-06', NULL, '429985', NULL),
(524, 657, 'E', 'D', 'Mr.', 'ASHWANI', 'KUMAR', 'SINGH', 1, 66, 2, 6, 414, '0', 'ashwani.singh@vnrseeds.in', 'M', 'N', 'N', 63, '2017-06-17', '2018-01-05', '346969', NULL),
(525, 658, 'E', 'D', 'Mr.', 'DEEPAK', 'KUMAR', 'PATEL', 1, 67, 2, 439, 601, '9993614124', '', 'M', 'Y', 'N', 1, '2017-06-19', '2020-09-04', '479891', NULL),
(526, 659, 'E', 'D', 'Mr.', 'SUSHIL ', 'PRASAD', 'RATURI', 1, 65, 2, 7, 345, '0', 'sushil.raturi@vnrseeds.in', 'M', 'N', 'N', 1, '2017-07-01', '2019-06-06', '423028', NULL),
(527, 660, 'E', 'D', 'Ms.', 'NEHA', '', 'VERMA', 1, 65, 2, 7, 414, '7248468534', 'neha.verma@vnrseeds.in', 'F', 'N', 'N', 1, '2017-07-01', '2018-07-06', '349876', NULL),
(528, 661, 'E', 'D', 'Mr.', 'DUDDUKUR', '', 'RAJASEKHAR', 1, 67, 2, 5, 89, '0', 'duddukur.rajasekhar@vnrseeds.in', 'M', 'N', 'N', 7, '2017-07-03', '2018-09-27', '349876', NULL),
(529, 25, 'E', 'D', 'Ms.', 'SHIVANGI', '', 'DUMKA', 3, 31, 21, 433, 410, '0', 'shivangidumka@gmail.com', 'F', 'N', 'N', 102, '2017-07-01', NULL, '351076', NULL),
(530, 662, 'E', 'D', 'Mr.', 'ATANU', '', 'DAS', 1, 64, 3, 285, 600, '0', 'atanudas.vspl@gmail.com', 'M', 'Y', 'N', 179, '2017-07-20', '2018-12-05', '396595', NULL),
(531, 663, 'E', 'A', 'Mr.', 'KUMAR', '', 'RAHUL', 1, 75, 6, 63, 51, '9177030653', 'kumar.rahul@vnrseeds.com', 'M', 'Y', 'N', 7, '2017-07-24', NULL, '6882051', NULL),
(532, 664, 'E', 'A', 'Ms.', 'TANVI ', '', 'SAXENA', 1, 68, 2, 3, 89, '7409697003', 'tanvi.saxena@vnrseeds.com', 'F', 'N', 'N', 1, '2017-08-01', NULL, '848389', NULL),
(533, 665, 'E', 'D', 'Mr.', 'GAJENDRA ', 'PRALHADRAO', 'KADU', 1, 69, 6, 67, 531, '9850097550', 'gajendra.kadu@vnrseeds.com', 'M', 'Y', 'N', 57, '2017-08-02', '2020-04-02', '1423865', NULL),
(534, 666, 'E', 'D', 'Mr.', 'HEMANT ', '', 'KUMAR', 1, 64, 6, 257, 11, '9896778262', 'hemantkumar.vspl@gmail.com', 'M', 'Y', 'N', 207, '2017-08-12', '2018-06-02', '289378', NULL),
(535, 26, 'E', 'A', 'Mr.', 'PRASHANT', '', 'RAWAT', 3, 31, 21, 623, 727, '9927248554', 'prashant.vnrnursery@gmail.com', 'M', 'N', 'N', 102, '2017-08-01', NULL, '548956', NULL),
(536, 27, 'E', 'D', 'Mr.', 'NEERAJ', 'SINGH', 'NEGI', 3, 31, 19, 296, 254, '9917262206', '', 'M', 'N', 'N', 102, '2017-08-21', '2017-09-17', '358128', NULL),
(537, 28, 'E', 'D', 'Mr.', 'KAMAL', 'KISHORE', 'JOSHI', 3, 31, 19, 411, 254, '9456713520', 'kamal.joshi@vnrnursery.in', 'M', 'N', 'N', 102, '2017-08-21', '2018-04-20', '362128', NULL),
(538, 667, 'E', 'A', 'Mr.', 'YOGESH ', 'KUMAR', 'SAHU', 1, 64, 8, 193, 109, '9691622143', 'yogeshsahu.vspl@gmail.com', 'M', 'N', 'N', 1, '2017-09-11', NULL, '370691', NULL),
(539, 668, 'E', 'A', 'Mr.', 'KADAKANCHI', '', 'SATHYANARAYANA', 1, 62, 2, 249, 108, '9866642198', 'kadakanchisathya@gmail.com', 'M', 'Y', 'N', 7, '2017-09-12', NULL, '284848', NULL),
(540, 669, 'E', 'A', 'Dr.', 'MANAS', 'SANJAY', 'SULE', 1, 68, 2, 473, 601, '9004051230', 'manas.sule@vnrseeds.com', 'M', 'Y', 'Y', 1, '2017-10-03', NULL, '1037288', NULL),
(541, 670, 'E', 'D', 'Ms.', 'MOHITA', '', 'DUBEY', 1, 63, 12, 347, 97, '7999660560', 'vspl.mkt@vnrseeds.com', 'F', 'N', 'N', 1, '2017-10-06', '2020-09-30', '333443', NULL),
(542, 671, 'E', 'A', 'Mr.', 'YELIMELA', '', ' KRISHNA', 1, 62, 2, 249, 179, '9032546590', 'yelimelakrishna@gmail.com', 'M', 'N', 'N', 7, '2017-10-09', NULL, '278541', NULL),
(543, 672, 'E', 'A', 'Mr.', 'SANTOSH', 'KUMAR', 'CHAUDHARY', 1, 65, 24, 237, 263, '8601029576', 'santosh.vspl4@gmail.com', 'M', 'N', 'N', 14, '2017-11-24', NULL, '547789', NULL),
(544, 673, 'E', 'A', 'Ms.', 'SHEETAL', '', 'DEWANGAN', 1, 65, 1, 198, 182, '9516538080', 'sheetal.dewangan@vnrseeds.com', 'F', 'N', 'N', 1, '2017-12-04', NULL, '366611', NULL),
(545, 674, 'E', 'A', 'Mr.', 'LOKESH', '', 'K M', 1, 68, 2, 3, 108, '8152085953', 'lokesh.km@vnrseeds.in', 'M', 'N', 'N', 7, '2017-12-11', NULL, '887098', NULL),
(546, 675, 'E', 'D', 'Mr.', 'ANUCHURI', 'ARUN', 'KUMAR', 1, 63, 6, 254, 220, '7673978967', 'anuchuri.arun.vspl@gmail.com', 'M', 'N', 'N', 68, '2017-12-15', '2019-02-04', '351578', NULL),
(547, 676, 'E', 'A', 'Mr.', 'OMKAR ', '', 'MAHILANG', 1, 64, 2, 31, 7, '9981088444', 'omkar.mahilang@vnrseeds.in', 'M', 'Y', 'N', 1, '2018-01-02', NULL, '481493', NULL),
(548, 677, 'E', 'D', 'Mr.', 'AASHUTOSH', '', '.', 1, 64, 4, 169, 362, '0', '', 'M', 'N', 'N', 22, '2018-01-02', '2018-01-02', '262992', NULL),
(549, 678, 'E', 'A', 'Mr.', 'ARJUN ', 'KUMAR', 'VERMA', 1, 66, 6, 68, 912, '9918900324', 'arjunkumar.verma@vnrseeds.com', 'M', 'Y', 'N', 128, '2018-01-02', NULL, '1046173', NULL),
(550, 679, 'E', 'A', 'Mr.', 'NEERAJ ', '', 'KUMAR', 1, 69, 6, 67, 34, '7765800504', 'neeraj.kumar@vnrseeds.com', 'M', 'Y', 'N', 37, '2018-01-02', NULL, '1695111', NULL),
(551, 680, 'E', 'D', 'Mr.', 'N', '', 'CHANDRASHEKHAR', 1, 69, 6, 67, 531, '9980504505', 'n.chandrashekhar@vnrseeds.com', 'M', 'Y', 'N', 77, '2018-01-05', '2019-01-14', '1647285', NULL),
(552, 681, 'E', 'D', 'Mr.', 'MANOHAR', 'BABASAHEB', 'TALEKAR', 1, 64, 24, 237, 120, '8600725163', 'manohar.vspl@gmail.com', 'M', 'Y', 'N', 14, '2018-01-12', '2019-12-31', '318458', NULL),
(553, 682, 'E', 'D', 'Mr.', 'AVINASH', 'NIRANJAN', 'SWAMI', 1, 63, 6, 254, 533, '9405048916', 'avinashswami.vspl@gmail.com', 'M', 'N', 'N', 210, '2018-01-19', '2019-06-07', '222380', NULL),
(554, 683, 'E', 'D', 'Mr.', 'PRAKHAR ', '', 'TRIPATHI', 1, 64, 6, 257, 241, '0', 'prakhartripathi.vspl@gmail.com', 'M', 'N', 'N', 67, '2018-02-21', '2018-11-07', '359978', NULL),
(555, 684, 'E', 'D', 'Mr.', 'RAMVIR', '', ' SINGH', 1, 65, 4, 306, 362, '8279791898', 'ramvirsingh.vspl@gmail.com', 'M', 'N', 'N', 22, '2018-03-01', '2020-10-25', '313099', NULL),
(556, 685, 'E', 'D', 'Mr.', 'KARANGULA', '', 'MALLIBABU', 1, 66, 6, 68, 220, '9491584886', 'kmallibabu.vspl@gmail.com', 'M', 'Y', 'N', 129, '2018-03-01', '2020-01-11', '767648', NULL),
(557, 686, 'E', 'D', 'Mr.', 'ANKUSH', '', 'HIWASE', 1, 63, 3, 215, 321, '0', 'ankushhiwase.vspl@gmail.com', 'M', 'N', 'N', 42, '2018-03-09', '2018-10-14', '296920', NULL),
(558, 687, 'E', 'A', 'Mr.', 'RAHUL', '', 'BADJARA', 1, 64, 25, 569, 195, '7987364686', 'rahulbadjara.vspl@gmail.com', 'M', 'Y', 'N', 14, '2018-03-10', NULL, '429230', NULL),
(559, 688, 'E', 'A', 'Mr.', 'AKHILESH', 'KUMAR', 'RAI', 1, 66, 6, 68, 726, '7211109955', 'akhileshrai.vspl@gmail.com', 'M', 'Y', 'N', 211, '2018-03-19', NULL, '959998', NULL),
(560, 689, 'E', 'A', 'Mr.', 'KOLLA', 'ASHOK', 'KUMAR', 1, 67, 6, 415, 597, '9618666467', 'ashokkolla.vnr@gmail.com', 'M', 'Y', 'N', 32, '2018-03-21', NULL, '800625', NULL),
(561, 690, 'E', 'D', 'Mr.', 'DINESH', 'P', 'G', 1, 65, 6, 255, 514, '0', 'dineshpg.vnr@gmail.com', 'M', 'Y', 'N', 86, '2018-03-21', '2018-04-28', '504488', NULL),
(562, 691, 'E', 'D', 'Mr.', 'BASAVARAJ', '', 'BARAKER', 1, 63, 6, 254, 531, '0', 'barakerbasavaraj.vnr@gmail.com', 'M', 'N', 'N', 213, '2018-03-21', '2019-03-17', '311978', NULL),
(563, 692, 'E', 'D', 'Mr.', 'MANAS', '', 'SANTRA', 1, 64, 6, 257, 261, '7278102640', 'vnr.manas@gmail.com', 'M', 'N', 'N', 256, '2018-03-28', '2020-09-18', '372171', NULL),
(564, 693, 'E', 'D', 'Mr.', 'SUMIT', '', 'KUMAR', 1, 66, 4, 373, 779, '9891155937', 'sumitkumar.vspl@gmail.com', 'M', 'Y', 'N', 284, '2018-04-02', '2020-03-31', '384491', NULL),
(565, 694, 'E', 'D', 'Mr.', 'SHREESH', '', 'MISHRA', 1, 64, 6, 257, 252, '0', 'shreeshmishra.vspl@gmail.com', 'M', 'N', 'N', 195, '2018-04-02', '2018-05-19', '450144', NULL),
(566, 695, 'E', 'D', 'Mr.', 'ATAR', 'SINGH', 'RAWAT', 1, 65, 6, 255, 924, '9754803235', 'atar.vspl@gmail.com', 'M', 'Y', 'N', 287, '2018-04-02', '2021-01-04', '584496', NULL),
(567, 696, 'E', 'D', 'Mr.', 'ARUN', 'PRAKASH', 'SINGH', 1, 64, 6, 257, 399, '0', 'arunprakash.vspl@gmail.com', 'M', 'N', 'N', 95, '2018-04-02', '2019-08-05', '318458', NULL),
(568, 697, 'E', 'A', 'Mr.', 'NAVEEN', '', 'RANA', 1, 65, 6, 255, 584, '9713821145', 'naveenrana.vspl@gmail.com', 'M', 'N', 'N', 260, '2018-04-02', NULL, '517159', NULL),
(569, 698, 'E', 'A', 'Mr.', 'LOKESH', 'KUMAR', '', 1, 63, 5, 57, 52, '9076966430', 'lokeshprajapati.vspl@gmail.com', 'M', 'Y', 'N', 14, '2018-04-05', NULL, '379679', NULL),
(570, 699, 'E', 'D', 'Mr.', 'SACHIN', '', 'PATIL', 1, 65, 6, 255, 718, '0', 'sbpatilvnr@gmail.com', 'M', 'Y', 'N', 216, '2018-04-10', '2019-05-16', '435382', NULL),
(571, 700, 'E', 'D', 'Mr.', 'PRASHANT', 'S', 'SUBBAPURMATH', 1, 66, 6, 68, 718, '9964834257', 'prashantssvnr@gmail.com', 'M', 'Y', 'N', 217, '2018-04-10', '2021-01-03', '621989', NULL),
(572, 701, 'E', 'D', 'Mr.', 'NAGABELLI', '', 'MAHENDER', 1, 65, 6, 255, 597, '8886622123', 'mahendern.vspl@gmail.com', 'M', 'Y', 'N', 247, '2018-04-14', '2019-08-31', '566481', NULL),
(573, 702, 'E', 'D', 'Mr.', 'RAHUL', '', 'KUMARIYA', 1, 66, 6, 68, 726, '7782015882', 'rahulkumariya.vspl@gmail.com', 'M', 'Y', 'N', 97, '2018-04-16', '2019-05-04', '615398', NULL),
(574, 703, 'E', 'D', 'Mr.', 'JAYANT', '', 'BIRLA', 1, 64, 6, 257, 34, '0', 'jayantbirla.vspl@gmail.com', 'M', 'Y', 'N', 222, '2018-04-16', '2018-12-17', '271780', NULL),
(575, 704, 'E', 'D', 'Mr.', 'VIJAY', 'KUMAR', 'YADAV', 1, 65, 6, 255, 731, '9758997753', 'vijayyadav.vspl@gmail.com', 'M', 'Y', 'N', 288, '2018-04-18', '2021-02-13', '487895', NULL),
(576, 705, 'E', 'A', 'Mr.', 'KHALID ABDUL', 'QYYUM', 'AHMAD', 1, 65, 6, 255, 946, '9359115315', 'khalid.vspl@gmail.com', 'M', 'Y', 'N', 81, '2018-04-18', NULL, '627055', NULL),
(577, 706, 'E', 'D', 'Mr.', 'LOKESH', '', 'SINGH', 1, 63, 6, 254, 252, '7087875461', 'lokeshsingh.vspl@gmail.com', 'M', 'N', 'N', 80, '2018-04-20', '2020-01-02', '330098', NULL),
(578, 707, 'E', 'D', 'Mr.', 'ANURAG  ', '', 'KUMAR', 1, 64, 6, 257, 252, '8740998660', 'anuragupadhyay.vspl@gmail.com', 'M', 'Y', 'N', 203, '2018-04-21', '2019-11-02', '420338', NULL),
(579, 708, 'E', 'A', 'Mr.', 'ASHISH', '', 'SINGH', 1, 64, 6, 257, 261, '7260012111', 'ashishsingh.vspl@gmail.com', 'M', 'Y', 'N', 59, '2018-04-25', NULL, '502628', NULL),
(580, 709, 'E', 'A', 'Mr.', 'CHANDRASEKHAR', '', '.', 1, 65, 6, 255, 718, '9663838107', 'dorechandrashekar.vspl@gmail.com', 'M', 'Y', 'N', 221, '2018-04-25', NULL, '600216', NULL),
(581, 710, 'E', 'D', 'Mr.', 'MAKTUMSAB', '', 'NADAF', 1, 64, 6, 257, 718, '8762056705', 'maktumsab.vspl@gmail.com', 'M', 'N', 'N', 216, '2018-04-25', '2020-12-18', '352991', NULL),
(582, 711, 'E', 'D', 'Mr.', 'LINGAMPELLY', '', ' SANDEEP', 1, 63, 6, 254, 220, '6300588780', 'lsandeep.vspl@gmail.com', 'M', 'N', 'N', 224, '2018-05-02', '2020-02-22', '348338', NULL),
(583, 712, 'E', 'A', 'Mr.', 'NERELLA', '', 'SUPREEM', 1, 64, 6, 257, 220, '9666923939', 'nsupreem.vspl@gmail.com', 'M', 'Y', 'N', 68, '2018-05-02', NULL, '482723', NULL),
(584, 713, 'E', 'A', 'Mr.', 'VIVEK ', 'VIKRAM', 'SINGH', 1, 70, 6, 66, 241, '7985278163', 'vivekvikram.singh@vnrseeds.com', 'M', 'Y', 'N', 1, '2018-05-03', NULL, '1820815', NULL),
(585, 714, 'E', 'D', 'Mr.', 'SHASHIIDHAR', '', 'TIWARI', 1, 65, 6, 255, 14, '9453975419', 'shashidhartiwari.vspl@gmail.com', 'M', 'Y', 'N', 191, '2018-05-03', '2021-04-25', '552306', NULL),
(586, 715, 'E', 'A', 'Mr.', 'ARUN', '', 'PATEL', 1, 65, 6, 255, 731, '9580707060', 'Arunpatel.vspl@gmail.com', 'M', 'Y', 'N', 295, '2018-05-03', NULL, '648875', NULL),
(587, 716, 'E', 'D', 'Mr.', 'DHIRENDRA', 'NARAYAN', 'DAS', 1, 65, 6, 255, 14, '9532943082', 'dhirendradas.vspl@gmail.com', 'M', 'Y', 'N', 226, '2018-05-04', '2018-12-03', '568522', NULL),
(588, 717, 'E', 'D', 'Mr.', 'SUMANT', '', 'SINGH', 1, 63, 6, 254, 252, '7007623658', 'singhsumant.vspl@gmail.com', 'M', 'N', 'N', 194, '2018-05-07', '2020-02-09', '345818', NULL),
(589, 718, 'E', 'A', 'Mr.', 'VISHNU', '', 'KUMAR', 1, 64, 6, 257, 550, '9759741922', 'vishnukumar.vspl@gmail.com', 'M', 'Y', 'N', 228, '2018-05-07', NULL, '459982', NULL),
(590, 719, 'E', 'D', 'Mr.', 'SHARATH', 'K', 'S', 1, 64, 6, 257, 718, '9743868528', 'sharathks.vspl@gmail.com', 'M', 'N', 'N', 115, '2018-05-10', '2021-01-31', '450191', NULL),
(591, 720, 'E', 'A', 'Ms.', 'SRISHTI', 'PRAVEEN', 'TAUNK', 1, 64, 1, 301, 58, '8770747214', 'srishti.taunk@vnrseeds.com', 'F', 'N', 'N', 1, '2018-05-10', NULL, '300011', NULL),
(592, 721, 'E', 'D', 'Mr.', 'MANOJ', '', 'KUMAR', 1, 63, 6, 254, 241, '0', 'manojkumar.vspl@gmail.com', 'M', 'Y', 'N', 3, '2018-05-14', '2018-11-30', '303098', NULL),
(593, 722, 'E', 'D', 'Mr.', 'VIJAY', '', 'KUMAR', 1, 66, 6, 68, 584, '9179991273', 'vijayskumar.vspl@gmail.com', 'M', 'Y', 'N', 31, '2018-05-15', '2018-09-14', '564684', NULL),
(594, 723, 'E', 'A', 'Mr.', 'MANOJ', 'KUMAR', 'SINGH', 1, 64, 6, 257, 915, '9536703064', 'manojsingh.vspl@gmail.com', 'M', 'Y', 'N', 110, '2018-05-16', NULL, '483754', NULL),
(595, 724, 'E', 'D', 'Mr.', 'DIGAMBER', '', 'KUMAR', 1, 64, 6, 257, 915, '9430196432', 'digamber.vspl@gmail.com', 'M', 'Y', 'N', 56, '2018-05-21', '2021-07-15', '581010', NULL),
(596, 725, 'E', 'A', 'Mr.', 'ANKUR', '', 'SHUKLA', 1, 65, 7, 208, 438, '8887764458', 'ankurshukla.vspl@gmail.com', 'M', 'Y', 'N', 95, '2018-05-22', NULL, '458780', NULL);
INSERT INTO `master_employee` (`EmployeeID`, `EmpCode`, `EmpType`, `EmpStatus`, `Title`, `Fname`, `Sname`, `Lname`, `CompanyId`, `GradeId`, `DepartmentId`, `DesigId`, `RepEmployeeID`, `Contact`, `Email`, `Gender`, `Married`, `DR`, `Location`, `DOJ`, `DateOfSepration`, `CTC`, `LastUpdated`) VALUES
(597, 726, 'E', 'A', 'Mr.', 'ARAVIND ', '', 'KANCHARLAPALLI', 1, 70, 6, 66, 531, '9963836353', 'aravind.kancharlapalli@vnrseeds.com', 'M', 'Y', 'N', 106, '2018-05-26', NULL, '1713544', NULL),
(598, 727, 'E', 'D', 'Mr.', 'POTHANABOINA', '', 'NAGARAJU', 1, 65, 4, 306, 359, '8008066104', 'pnagaraju.vspl@gmail.com', 'M', 'Y', 'N', 229, '2018-05-28', '2020-10-23', '299899', NULL),
(599, 728, 'E', 'A', 'Mr.', 'THOMMANDRU', '', 'RATNAM', 1, 66, 4, 373, 359, '8096044980', 'tratnam.vspl@gmail.com', 'M', 'Y', 'N', 229, '2018-05-28', NULL, '335039', NULL),
(600, 729, 'E', 'D', 'Dr.', 'SANJEEV', '', 'KUMAR', 1, 68, 3, 475, 719, '9675888234', 'sanjeev.kumar@vnrseeds.com', 'M', 'Y', 'Y', 4, '2018-05-29', '2020-03-31', '1058359', NULL),
(601, 730, 'E', 'A', 'Dr.', 'KISLAY', 'KUMAR', 'SINHA', 1, 74, 2, 244, 89, '9279133837', 'kislay.sinha@vnrseeds.com', 'M', 'Y', 'Y', 1, '2018-06-01', NULL, '4801397', NULL),
(602, 731, 'E', 'D', 'Dr.', 'SUJEET', '', 'KUMAR', 1, 68, 2, 439, 601, '7411863362', 'sujeet.kumar@vnrseeds.com', 'M', 'Y', 'Y', 1, '2018-06-01', '2021-04-17', '728411', NULL),
(603, 732, 'E', 'A', 'Mr.', 'MOHAMMED ', '', 'AHMAD', 1, 65, 6, 255, 597, '9885478655', 'mdahmad.vspl@gmail.com', 'M', 'Y', 'N', 230, '2018-06-02', NULL, '823053', NULL),
(604, 733, 'E', 'A', 'Mr.', 'SUNIL ', 'KUMAR', 'KOTHARI', 1, 63, 5, 57, 246, '7067133479', 'sunilkothari07oct@gmail.com', 'M', 'N', 'N', 14, '2018-06-04', NULL, '316367', NULL),
(605, 734, 'E', 'A', 'Mr.', 'SATISH', 'TIMMAPPA', 'MULLUR', 1, 65, 6, 255, 718, '9964858060', 'satishmullur.vspl@gmail.com', 'M', 'N', 'N', 86, '2018-06-08', NULL, '697093', NULL),
(606, 735, 'E', 'D', 'Mr.', 'SADASHIV', 'MUTTANAGOUDA', 'PATIL', 1, 64, 6, 257, 718, '9844751907', 'sadashivpatil.vspl@gmail.com', 'M', 'Y', 'N', 178, '2018-06-08', '2020-11-19', '528894', NULL),
(607, 736, 'E', 'A', 'Mr.', 'NAMDEO', 'UTTAMRAO', 'KHARAT', 1, 66, 6, 68, 726, '8275830053', 'namdeokharat.vspl@gmail.com', 'M', 'Y', 'N', 61, '2018-06-14', NULL, '836259', NULL),
(608, 737, 'E', 'A', 'Mr.', 'MURUGESAN', '', 'THANGARASU', 1, 65, 6, 255, 370, '9786398804', 'murugesant.vspl@gmail.com', 'M', 'Y', 'N', 233, '2018-06-16', NULL, '434628', NULL),
(609, 738, 'E', 'A', 'Mr.', 'RAJA', '', 'S', 1, 64, 6, 257, 370, '7418656231', 'rajas.vspl@gmail.com', 'M', 'Y', 'N', 234, '2018-06-16', NULL, '417349', NULL),
(610, 739, 'E', 'D', 'Mr.', 'KAPIL', 'DEV', 'SHARMA', 1, 63, 6, 254, 550, '8954242554', 'kapildevsharma.vspl@gmail.com', 'M', 'Y', 'N', 134, '2018-06-26', '2020-02-10', '368978', NULL),
(611, 740, 'E', 'D', 'Mr.', 'AMIT ', '', 'MISHRA', 1, 64, 3, 215, 15, '9984909007', 'amitmishra.vspl@gmail.com', 'M', 'Y', 'N', 41, '2018-07-02', '2020-07-02', '405497', NULL),
(612, 741, 'E', 'D', 'Mr.', 'LAKSHMIKANTH', '', 'R', 1, 64, 3, 215, 238, '9844466239', 'lakshmikanthr.vspl@gmail.com', 'M', 'N', 'N', 246, '2018-07-02', '2020-08-08', '405497', NULL),
(613, 742, 'E', 'D', 'Mr.', 'ANKUSH', '', 'GODARA', 1, 63, 3, 287, 600, '9166259493', 'ankushgodara.vspl@gmail.com', 'M', 'N', 'N', 70, '2018-07-02', NULL, '396977', NULL),
(614, 743, 'E', 'A', 'Mr.', 'AMIT', '', 'THAKUR', 1, 65, 3, 607, 143, '7052603934', 'amitthakur.vspl@gmail.com', 'M', 'N', 'N', 25, '2018-07-02', NULL, '497118', NULL),
(615, 744, 'E', 'D', 'Mr.', 'VIVEK', '', 'BARCHE', 1, 63, 3, 287, 143, '8269593352', 'vivekbarche.vspl@gmail.com', 'M', 'N', 'N', 60, '2018-07-02', NULL, '396977', NULL),
(616, 745, 'E', 'D', 'Mr.', 'KULDEEP', '', 'BAIRAGI', 1, 63, 3, 287, 321, '9806635146', 'kuldeepbairagi.vspl@gmail.com', 'M', 'N', 'N', 23, '2018-07-02', '2019-06-14', '336458', NULL),
(617, 746, 'E', 'D', 'Mr.', 'TIKAMCHAND', '', '', 1, 64, 3, 285, 15, '9685173368', 'tikamchand.vspl@gmail.com', 'M', 'N', 'N', 4, '2018-07-02', '2020-10-06', '371723', NULL),
(618, 747, 'E', 'D', 'Mr.', 'NAVDEEP', '', 'MOHANTA', 1, 63, 3, 287, 15, '7683812414', 'navdeepmohanta.vspl@gmail.com', 'M', 'N', 'N', 142, '2018-07-02', NULL, '396977', NULL),
(619, 748, 'E', 'A', 'Mr.', 'ABDUL', '', 'ALEEM', 1, 65, 3, 607, 927, '8948770675', 'abdulaleem.vspl@gmail.com', 'M', 'N', 'N', 199, '2018-07-02', NULL, '494283', NULL),
(620, 749, 'E', 'D', 'Mr.', 'YADVENDRA', '', 'SINGH', 1, 63, 3, 215, 143, '7987862380', 'yadvendrasingh.vspl@gmail.com', 'M', 'N', 'N', 269, '2018-07-02', '2020-09-09', '366611', NULL),
(621, 750, 'E', 'A', 'Mr.', 'BRIJ', '', 'NAYAK', 1, 65, 3, 607, 15, '9621499491', 'brijnayak.vspl@gmail.com', 'M', 'N', 'N', 4, '2018-07-02', NULL, '487607', NULL),
(622, 751, 'E', 'D', 'Mr.', 'SHREEDHAR', '', 'UTAGI', 1, 63, 2, 177, 345, '7406180643', 'shreedharutagi.vspl@gmail.com', 'M', 'N', 'N', 9, '2018-07-02', NULL, '396977', NULL),
(623, 752, 'E', 'D', 'Mr.', 'BOINA', '', 'RAKESH', 1, 64, 3, 215, 238, '8143779946', 'rakeshboina.vspl@gmail.com', 'M', 'N', 'N', 106, '2018-07-02', '2020-08-06', '381791', NULL),
(624, 753, 'E', 'A', 'Mr.', 'BHOJANE', 'SUNIL', 'BHAGAWANRAO', 1, 65, 3, 607, 143, '9665458056', 'sunilbhojane.vspl@gmail.com', 'M', 'Y', 'N', 46, '2018-07-02', NULL, '531848', NULL),
(625, 754, 'E', 'A', 'Mr.', 'KIRTI', 'RANJAN', 'VERMA', 1, 65, 3, 607, 321, '7007538826', 'kirtiranjan.vspl@gmail.com', 'M', 'N', 'N', 10, '2018-07-02', NULL, '563976', NULL),
(626, 755, 'E', 'D', 'Mr.', 'LAXMINARAYAN', '', 'PATIDAR', 1, 64, 3, 285, 927, '8052756524', 'laxminarayanpatidar.vspl@gmail.com', 'M', 'Y', 'N', 251, '2018-07-02', '2020-09-30', '384311', NULL),
(627, 756, 'E', 'A', 'Mr.', 'ROSHAN', '', 'BAUNTHIYAL', 1, 64, 4, 306, 850, '6268116995', 'roshanbaunthiyal@gmail.com', 'M', 'N', 'N', 263, '2018-07-02', NULL, '479372', NULL),
(628, 757, 'E', 'A', 'Mr.', 'ROHIT', '', 'VERMA', 1, 64, 4, 306, 845, '7253911173', 'rohitverma.vspl@gmail.com', 'M', 'N', 'N', 272, '2018-07-02', NULL, '430529', NULL),
(629, 758, 'E', 'D', 'Ms.', 'NEHA', '', 'KUMARI', 1, 66, 2, 6, 89, '7004314549', 'neha.kumari@vnrseeds.com', 'F', 'N', 'N', 15, '2018-07-02', '2019-05-04', '396977', NULL),
(630, 759, 'E', 'A', 'Ms.', 'SONAM', 'RANI', 'AGRAHARI', 1, 68, 2, 5, 89, '8738045353', 'sonamrani.agrahari@vnrseeds.com', 'F', 'N', 'N', 1, '2018-07-03', NULL, '665774', NULL),
(631, 760, 'E', 'D', 'Mr.', 'BHATT', 'PARTH', 'KISHORBHAI', 1, 67, 2, 5, 89, '9723413369', 'parth.bhatt@vnrseeds.com', 'M', 'N', 'N', 7, '2018-07-03', '2019-09-30', '415323', NULL),
(632, 761, 'E', 'D', 'Mr.', 'UDAYBEER', '', 'VISHWAKARMA', 1, 65, 2, 7, 345, '9685103278', 'udaybeer.vishwakarma@vnrseeds.com', 'M', 'N', 'N', 1, '2018-07-03', '2019-04-20', '336458', NULL),
(633, 762, 'E', 'D', 'Mr.', 'CHURAMANI', '', 'KUMAR', 1, 65, 2, 7, 345, '9693292139', 'churamani.kumar@vnrseeds.com', 'M', 'N', 'N', 1, '2018-07-03', '2019-05-08', '336458', NULL),
(634, 763, 'E', 'A', 'Mr.', 'MRITYUNJAY', 'KUMAR', 'RAI', 1, 65, 2, 7, 345, '7080166535', 'mrityunjay.rai@vnrseeds.com', 'M', 'N', 'N', 63, '2018-07-03', NULL, '427412', NULL),
(635, 764, 'E', 'D', 'Mr.', 'ROHIT', '', 'TYAGI', 1, 65, 2, 7, 414, '9456862617', 'rohit.tyagi@vnrseeds.com', 'M', 'N', 'N', 63, '2018-07-03', '2019-07-06', '336458', NULL),
(636, 765, 'E', 'A', 'Ms.', 'SUPRIYA', '', 'SINGH', 1, 65, 2, 7, 414, '9584517675', 'supriyasingh.rajpoot@vnrseeds.com', 'F', 'N', 'N', 1, '2018-07-03', NULL, '423792', NULL),
(637, 766, 'E', 'D', 'Mr.', 'DHEERENDRA', '', 'SINGH', 1, 65, 2, 7, 66, '9753963912', 'dheerendra.singh@vnrseeds.com', 'M', 'N', 'N', 7, '2018-07-03', '2019-05-13', '336458', NULL),
(638, 767, 'E', 'D', 'Ms.', 'NIBEDITA', '', 'PAUL', 1, 65, 2, 7, 532, '9519638901', 'nibedita.paul@vnrseeds.com', 'F', 'N', 'N', 1, '2018-07-03', '2019-10-19', '336458', NULL),
(639, 768, 'E', 'A', 'Mr.', 'VAIBHAV ', '', 'SINGH', 1, 64, 4, 306, 850, '8896220299', 'vaibhavsingh.vspl@gmail.com', 'M', 'N', 'N', 263, '2018-07-03', NULL, '436003', NULL),
(640, 769, 'E', 'D', 'Mr.', 'SAURABH', '', 'SINGH', 1, 63, 4, 169, 504, '8120782886', 'saurabhsingh.vspl@gmail.com', 'M', 'N', 'N', 22, '2018-07-03', '2019-01-31', '329978', NULL),
(641, 770, 'E', 'D', 'Mr.', 'PRAVEEN', '', 'RATHORE', 1, 63, 4, 169, 504, '8223882585', '', 'M', 'N', 'N', 22, '2018-07-03', '2018-10-02', '329978', NULL),
(642, 771, 'E', 'D', 'Mr.', 'ANURAG', '', 'PRAJAPATI', 1, 64, 3, 215, 321, '8052645223', 'anuragprajapati.vspl@gmail.com', 'M', 'Y', 'N', 46, '2018-07-03', '2020-12-31', '450395', NULL),
(643, 772, 'E', 'A', 'Mr.', 'AKHAND', 'KUMAR', 'YADAV', 1, 65, 6, 255, 912, '9794250040', 'akhandyadav.vspl@gmail.com', 'M', 'Y', 'N', 190, '2018-07-03', NULL, '544132', NULL),
(644, 773, 'E', 'D', 'Mr.', 'DHEERAJ', '', 'KUMAR', 1, 64, 6, 257, 726, '8445474706', 'dheerajkumar.vspl@gmail.com', 'M', 'Y', 'N', 60, '2018-07-03', '2020-05-09', '474599', NULL),
(645, 774, 'E', 'D', 'Mr.', 'ZAPADIYA', 'VIJAYKUMAR', 'JAGADISHBHAI', 1, 67, 2, 5, 89, '9687526090', 'zapadiya.vijaykumar@vnrseeds.com', 'M', 'N', 'N', 1, '2018-07-03', '2018-09-21', '411003', NULL),
(646, 775, 'E', 'D', 'Ms.', 'PRIYA', '', 'MEHTA', 1, 65, 2, 7, 345, '8924018670', 'priya.mehta@vnrseeds.com', 'F', 'N', 'N', 1, '2018-07-04', '2019-04-16', '336458', NULL),
(647, 776, 'E', 'D', 'Mr.', 'GOURAV', '', 'DEVADA', 1, 63, 4, 169, 362, '9424003241', 'gouravdevada.vspl@gmail.com', 'M', 'Y', 'N', 22, '2018-07-04', '2018-12-19', '329978', NULL),
(648, 777, 'E', 'D', 'Mr.', 'DHANRAJ ', '', 'MEENA', 1, 67, 2, 5, 89, '6304067245', 'dhanraj.meena@vnrseeds.com', 'M', 'N', 'N', 1, '2018-07-09', '2020-01-31', '476477', NULL),
(649, 778, 'E', 'A', 'Dr.', 'MAHIMA', '', 'DUBEY', 1, 68, 2, 439, 601, '7024710830', 'mahima.dubey@vnrseeds.com', 'F', 'Y', 'Y', 1, '2018-07-11', NULL, '700271', NULL),
(650, 29, 'E', 'D', 'Mr.', 'RAHUL', '', 'PALOTRA', 3, 31, 21, 412, 410, '7697711518', 'rahulpalotra.vspl@gmail.com', 'M', 'N', 'N', 102, '2018-07-02', '2021-01-03', '406559', NULL),
(651, 30, 'E', 'D', 'Mr.', 'DEEPAK', '', 'NAGAR', 3, 31, 21, 412, 410, '9554852893', 'deepaknagar.vspl@gmail.com', 'M', 'N', 'N', 237, '2018-07-02', '2021-01-03', '421763', NULL),
(652, 779, 'E', 'D', 'Mr.', 'VEERAVALLI', 'ASHOK ', 'BABU', 1, 63, 6, 286, 597, '8179712010', 'ashokbabu.vspl@gmail.com', 'M', 'N', 'N', 106, '2018-07-18', '2018-09-13', '347978', NULL),
(653, 780, 'E', 'A', 'Ms.', 'AKANKSHA ', '', 'NEGI', 1, 65, 2, 7, 281, '8941069303', 'akanksha.negi@vnrseeds.com', 'F', 'N', 'N', 15, '2018-08-01', NULL, '437475', NULL),
(654, 781, 'E', 'A', 'Mr.', 'SHAIK ', 'SHABBEER', 'BASHA', 1, 66, 6, 68, 220, '9885153811', 'shabbeerbasha.vspl@gmail.com', 'M', 'Y', 'N', 17, '2018-08-06', NULL, '742069', NULL),
(655, 31, 'E', 'D', 'Mr.', 'KAMLESH', '', 'PATEL', 3, 31, 19, 410, 445, '9669774214', 'kamleshvnrnursery@gmail.com', 'M', 'N', 'N', 102, '2018-07-20', '2021-05-08', '457487', NULL),
(656, 782, 'E', 'D', 'Mr.', 'SHASHI', 'KUMAR', 'SINGH', 1, 64, 6, 257, 584, '9109999101', 'shashisingh.vspl@gmail.com', 'M', 'N', 'N', 80, '2018-08-13', '2020-10-15', '364627', NULL),
(657, 783, 'E', 'A', 'Mr.', 'GIRISH', '', 'R', 1, 61, 2, 10, 89, '9739736292', 'girish.r@vnrseeds.com', 'M', 'Y', 'N', 204, '2018-08-16', NULL, '311639', NULL),
(658, 784, 'E', 'A', 'Mr.', 'VIVEK ', 'KUMAR', 'PANDEY', 1, 65, 6, 255, 731, '9918187777', 'vivekpandey.vspl@gmail.com', 'M', 'N', 'N', 39, '2018-08-21', NULL, '602535', NULL),
(659, 785, 'E', 'D', 'Mr.', 'SUNIL', '', 'YADAV', 1, 64, 6, 257, 726, '9570187878', 'sunilyadav.vspl@gmail.com', 'M', 'Y', 'N', 24, '2018-08-27', '2019-10-20', '406762', NULL),
(660, 32, 'E', 'D', 'Mr.', 'BHOOMI', '', 'RATHOD', 3, 31, 26, 295, 254, '9589237733', 'bhoomirathod0808@gmail.com', 'M', 'N', 'N', 102, '2018-07-20', NULL, '0', NULL),
(661, 786, 'E', 'A', 'Mr.', 'ASHISH', '', 'SHRIVASTAVA', 1, 63, 6, 254, 392, '9864788298', 'ashishshrivastava.vspl@gmail.com', 'M', 'N', 'N', 241, '2018-09-01', NULL, '404095', NULL),
(662, 787, 'E', 'A', 'Mr.', 'JAYESH', 'KUMAR', 'POONIYA', 1, 68, 8, 112, 110, '8104941692', 'vspl.cs@vnrseeds.com', 'M', 'Y', 'N', 1, '2018-09-01', NULL, '547176', NULL),
(663, 788, 'E', 'A', 'Mr.', 'VANTRASI', '', 'BHOOPAL', 1, 61, 2, 249, 66, '9542717952', 'bhoopal9542@gmail.com', 'M', 'N', 'N', 7, '2018-09-01', NULL, '227737', NULL),
(664, 789, 'E', 'D', 'Mr.', 'SUJIT', '', 'SINGH', 1, 64, 8, 193, 109, '8178210787', 'sujit.singh@vnrseeds.com', 'M', 'Y', 'N', 1, '2018-09-03', '2020-01-06', '250118', NULL),
(665, 790, 'E', 'D', 'Mr.', 'KATIPELLY', 'ROHAN', 'REDDY', 1, 63, 4, 306, 362, '8331859275', 'krohanreddy.vspl@gmail.com', 'M', 'N', 'N', 22, '2018-09-24', '2020-02-17', '396977', NULL),
(666, 791, 'E', 'D', 'Mr.', 'BURRI', '', 'NIKHIL', 1, 63, 4, 169, 362, '7743864027', 'burrinikhil.vspl@gmail.com', 'M', 'N', 'N', 22, '2018-09-24', '2019-04-26', '336458', NULL),
(667, 792, 'E', 'A', 'Mr.', 'BASANT', '', 'SINGH', 1, 67, 4, 372, 850, '7978159002', 'basantsingh.vspl@gmail.com', 'M', 'Y', 'N', 242, '2018-10-01', NULL, '733246', NULL),
(668, 793, 'E', 'A', 'Mr.', 'SHIVNARAYAN', '', '.', 1, 64, 4, 306, 667, '8120350677', 'shivnarayan.vspl@gmail.com', 'M', 'Y', 'N', 162, '2018-10-01', NULL, '406231', NULL),
(669, 794, 'E', 'D', 'Mr.', 'RAJKUMAR', '', 'DAS', 1, 65, 6, 255, 916, '9692313328', 'rajkumardas.vspl@gmail.com', 'M', 'N', 'N', 243, '2018-10-01', '2021-03-21', '438839', NULL),
(670, 795, 'E', 'A', 'Mr.', 'RAJENDRA', 'KUMAR', 'PAL', 1, 62, 27, 482, 354, '8085172040', 'rajendrapal.vspl@gmail.com', 'M', 'Y', 'N', 31, '2018-10-01', NULL, '314735', NULL),
(671, 796, 'E', 'D', 'Mr.', 'DHEERENDRA', '', 'SONI', 1, 65, 6, 255, 584, '6263448228', 'dheerendrasoni.vspl@gmail.com', 'M', 'Y', 'N', 31, '2018-10-03', '2021-03-15', '584178', NULL),
(672, 33, 'E', 'A', 'Mr.', 'SAZID', '', 'RAZA', 3, 31, 19, 624, 445, '0', 'sazidraza.vnrnursery@gmail.com', 'M', 'N', 'N', 102, '2018-07-20', NULL, '438850', NULL),
(673, 797, 'E', 'D', 'Mr.', 'MANISH', '', '.', 1, 63, 25, 169, 195, '0', '', 'M', 'N', 'N', 14, '2018-10-12', '2018-10-16', '329978', NULL),
(674, 798, 'E', 'D', 'Mr.', 'VISHAL', '', 'KUMAR', 1, 63, 25, 169, 361, '8115368276', 'vishalkumar.vspl@gmail.com', 'M', 'N', 'N', 118, '2018-10-12', '2019-04-17', '336458', NULL),
(675, 799, 'E', 'D', 'Mr.', 'SHUBHAM', '', 'SINGH', 1, 63, 25, 169, 195, '9399482294', 'shubhamsingh.vspl@gmail.com', 'M', 'N', 'N', 14, '2018-10-12', '2018-10-16', '329978', NULL),
(676, 800, 'E', 'A', 'Mr.', 'VIPUL', '', 'SINGH', 1, 61, 27, 482, 1249, '6363708928', '19.vipulsingh@gmail.com', 'M', 'N', 'N', 215, '2018-10-12', NULL, '281562', NULL),
(677, 801, 'E', 'A', 'Mr.', 'SARJUN', '', 'CHAUHAN', 1, 61, 27, 483, 354, '9328827896', 'sarjunchauhan.vspl@gmail.com', 'M', 'N', 'N', 167, '2018-10-15', NULL, '244975', NULL),
(678, 802, 'E', 'D', 'Mr.', 'YOGESH', 'ARUN', 'SHINDE', 1, 67, 2, 5, 89, '8605324807', 'yogesh.shinde@vnrseeds.com', 'M', 'N', 'N', 1, '2018-10-20', '2020-12-30', '386291', NULL),
(679, 803, 'E', 'A', 'Mr.', 'DEVENDRA', '', '.', 1, 65, 2, 7, 692, '9755665893', 'devendra.mewada@vnrseeds.com', 'M', 'N', 'N', 1, '2018-10-22', NULL, '417324', NULL),
(680, 804, 'E', 'A', 'Mr.', 'DIVYANSH', '', 'VERMA', 1, 65, 2, 7, 414, '8765001889', 'divyansh.verma@vnrseeds.com', 'M', 'N', 'N', 1, '2018-10-23', NULL, '413471', NULL),
(681, 805, 'E', 'A', 'Mr.', 'RAKESH', 'KUMAR', 'SHARMA', 1, 66, 6, 68, 399, '9935175424', 'rakeshkumarsharma.vspl@gmail.com', 'M', 'Y', 'N', 2, '2018-10-25', NULL, '570002', NULL),
(682, 806, 'E', 'D', 'Mr.', 'AKSHAY', 'D', 'A', 1, 67, 2, 5, 89, '9742027177', 'akshay.da@vnrseeds.com', 'M', 'N', 'N', 1, '2018-10-26', '2020-04-15', '476477', NULL),
(683, 807, 'E', 'D', 'Mr.', 'GOPAL', 'SHANKARRAO', 'DESHMUKH', 1, 65, 6, 255, 726, '9637506580', 'gopalsdeshmukh.vspl@gmail.com', 'M', 'Y', 'N', 61, '2018-10-29', '2020-10-15', '494595', NULL),
(684, 808, 'E', 'D', 'Mr.', 'UMESH', 'BALKRUSHNA', 'KUBADE', 1, 63, 24, 300, 294, '7798479774', 'umeshkubade.vspl@gmail.com', 'M', 'N', 'N', 14, '2018-10-29', '2019-09-07', '292258', NULL),
(685, 809, 'E', 'D', 'Mr.', 'VIJAY', '', 'PATIDAR', 1, 63, 24, 300, 294, '7024070250', 'vijaypatidar.vspl@gmail.com', 'M', 'N', 'N', 14, '2018-10-29', '2018-12-24', '289378', NULL),
(686, 810, 'E', 'A', 'Mr.', 'SUNEEL', 'KUMAR', 'YADAV', 1, 64, 24, 237, 263, '9557265636', 'suneelkumaryadav.vspl@gmail.com', 'M', 'N', 'N', 14, '2018-11-01', NULL, '440322', NULL),
(687, 811, 'E', 'D', 'Dr.', 'HARI', '', 'KESH', 1, 68, 2, 5, 89, '9467083785', 'hari.kesh@vnrseeds.com', 'M', 'Y', 'Y', 1, '2018-11-12', '2020-05-29', '782194', NULL),
(688, 812, 'E', 'D', 'Mr.', 'MALA', '', 'MAHESH', 1, 61, 2, 249, 1078, '9908315833', 'm.maheshsunny6@gmail.com', 'M', 'Y', 'N', 7, '2018-11-15', '2021-06-21', '197342', NULL),
(689, 813, 'E', 'D', 'Mr.', 'JIBAN', 'KUMAR', 'ACHARYA', 1, 61, 4, 132, 667, '8018430329', 'jibanacharya.vspl@gmail.com', 'M', 'N', 'N', 187, '2018-11-15', '2020-01-25', '205243', NULL),
(690, 814, 'E', 'A', 'Mr.', 'SUSHIL', '', 'KUMAR', 1, 65, 6, 255, 399, '9719190177', 'sushilkumar.vspl@gmail.com', 'M', 'Y', 'N', 188, '2018-11-16', NULL, '523614', NULL),
(691, 815, 'E', 'A', 'Mr.', 'IMRAN', 'ABBAS', 'PANHALKAR', 1, 65, 6, 255, 913, '9420229119', 'imranabbas.vspl@gmail.com', 'M', 'Y', 'N', 245, '2018-11-16', NULL, '634750', NULL),
(692, 816, 'E', 'A', 'Mr.', 'SUNIL', 'YOGRAJ', 'PATIL', 1, 68, 2, 3, 89, '7588193713', 'sunilyograj.patil@vnrseeds.com', 'M', 'Y', 'N', 226, '2018-12-04', NULL, '851574', NULL),
(693, 817, 'E', 'A', 'Mr.', 'VIRENDRA', 'KUMAR', 'YADAV', 1, 64, 25, 217, 266, '7389377765', 'virendrayadav.vspl@gmail.com', 'M', 'N', 'N', 118, '2018-12-04', NULL, '413005', NULL),
(694, 10003, 'E', 'A', 'Mr.', 'PURAN ', '', 'SAHU', 1, 61, 28, 484, 224, '0', '', 'M', 'Y', 'N', 9, '2005-04-01', NULL, '0', NULL),
(695, 818, 'E', 'A', 'Mr.', 'VANGALA', 'MALLIKARJUNA', 'REDDY', 1, 65, 3, 607, 321, '9441941110', 'mallikarjunareddy.vspl@gmail.com', 'M', 'Y', 'N', 106, '2018-12-13', NULL, '525736', NULL),
(696, 819, 'E', 'D', 'Mr.', 'ANKIT ', '', 'SINGH', 1, 64, 6, 257, 4, '8318711049', 'ankitsingh.vspl@gmail.com', 'M', 'N', 'N', 3, '2019-01-03', '2021-04-20', '395483', NULL),
(697, 820, 'E', 'D', 'Mr.', 'VIKAS', 'KUMAR', 'SINGH', 1, 64, 6, 257, 261, '8887786255', 'vikasksingh.vspl@gmail.com', 'M', 'Y', 'N', 232, '2019-01-03', '2019-11-18', '348717', NULL),
(698, 821, 'E', 'D', 'Mr.', 'MERUGU', '', 'MAHESH', 1, 64, 6, 257, 597, '9340335620', 'merugumahesh.vspl@gmail.com', 'M', 'N', 'N', 106, '2019-01-07', '2020-05-04', '354458', NULL),
(699, 822, 'E', 'A', 'Mr.', 'AVINASH', '', 'KUMAR', 1, 64, 6, 257, 915, '7004942608', 'avinashkumar.vspl@gmail.com', 'M', 'Y', 'N', 73, '2019-01-07', NULL, '430210', NULL),
(700, 823, 'E', 'D', 'Mr.', 'VIKASH', '', 'KUMAR', 1, 64, 6, 257, 449, '9905772224', 'vikashkumar.vspl@gmail.com', 'M', 'Y', 'N', 108, '2019-01-11', '2020-02-29', '380891', NULL),
(701, 824, 'E', 'A', 'Mr.', 'KAILA', 'VAMSHIKAR', 'REDDY', 1, 61, 2, 249, 179, '8179972600', 'vamshikarreddykaila@gmail.com', 'M', 'N', 'N', 7, '2019-01-15', NULL, '224548', NULL),
(702, 825, 'E', 'D', 'Mr.', 'JANGAM', '', 'OMPRAKASH', 1, 63, 4, 226, 362, '9704466396', 'jangamomprakash.vspl@gmail.com', 'M', 'Y', 'N', 22, '2019-01-23', '2020-10-19', '216890', NULL),
(703, 826, 'E', 'A', 'Mr.', 'PUDARI', '', 'SURESH', 1, 65, 4, 306, 359, '9849575336', 'vsplpudarisuresh@gmail.com', 'M', 'Y', 'N', 229, '2019-01-23', NULL, '327131', NULL),
(704, 827, 'E', 'D', 'Mr.', 'SUPRABHAT', '', 'GHOSH', 1, 63, 4, 226, 667, '6294133102', 'suprabhatghosh.vspl@gmail.com', 'M', 'Y', 'N', 244, '2019-01-25', '2020-01-17', '199048', NULL),
(705, 828, 'E', 'A', 'Mr.', 'NARAD', 'RAM', 'GENDARE', 1, 62, 24, 365, 382, '6264494820', 'naradramgendare.vspl@gmail.com', 'M', 'Y', 'N', 14, '2019-02-01', NULL, '265963', NULL),
(706, 34, 'E', 'D', 'Ms.', 'SWARNDEEP ', 'KAUR', 'AJMANI', 3, 31, 26, 295, 254, '8602943002', '', 'F', 'N', 'N', 102, '2018-11-01', NULL, '178303', NULL),
(707, 829, 'E', 'A', 'Mr.', 'ARUN', 'KUMAR', 'YADAV', 1, 64, 6, 257, 924, '9918792391', 'arunyadav.vspl@gmail.com', 'M', 'Y', 'N', 172, '2019-02-11', NULL, '388775', NULL),
(708, 830, 'E', 'A', 'Mr.', 'SHANKAR', 'DUTT', 'BAWARI', 1, 61, 2, 249, 108, '7075243474', 'shankarsonu06@gmail.com', 'M', 'N', 'N', 7, '2019-02-13', NULL, '197252', NULL),
(709, 831, 'E', 'A', 'Mr.', 'CHERALA', '', 'ARAVIND', 1, 64, 6, 257, 220, '9959849488', 'cheralaaravind.vspl@gmail.com', 'M', 'Y', 'N', 7, '2019-02-20', NULL, '402635', NULL),
(710, 832, 'E', 'D', 'Mr.', 'SUMIT', '', 'KUMAR', 1, 64, 6, 256, 4, '8789111954', 'sumitgour.vspl@gmail.com', 'M', 'N', 'N', 292, '2019-02-25', '2020-10-07', '380099', NULL),
(711, 833, 'E', 'D', 'Mr.', 'AMARESH', 'SEKHAR', 'SAMAL', 1, 64, 6, 257, 375, '7750012748', 'amareshsamal.vspl@gmail.com', 'M', 'N', 'N', 142, '2019-02-25', '2021-05-11', '465309', NULL),
(712, 834, 'E', 'A', 'Mr.', 'SAISMIT', '', 'DASH', 1, 64, 6, 257, 584, '7008845046', 'saismitdash.vspl@gmail.com', 'M', 'N', 'N', 118, '2019-02-25', NULL, '457823', NULL),
(713, 835, 'E', 'A', 'Mr.', 'PRATHIT', 'PRASENJIT', 'PANDA', 1, 64, 6, 257, 915, '8984403683', 'prathitpanda.vspl@gmail.com', 'M', 'N', 'N', 253, '2019-02-25', NULL, '457908', NULL),
(714, 836, 'E', 'A', 'Mr.', 'SUDEEP', 'KUMAR', 'PRADHAN', 1, 64, 6, 257, 375, '7789933851', 'sudeeppradhan.vspl@gmail.com', 'M', 'N', 'N', 355, '2019-02-25', NULL, '471040', NULL),
(715, 837, 'E', 'D', 'Mr.', 'ROHAN', 'KUMAR', 'SATAPATHY', 1, 63, 6, 286, 375, '7008950927', 'rohansatapathy.vspl@gmail.com', 'M', 'N', 'N', 121, '2019-02-25', '2019-08-31', '354458', NULL),
(716, 838, 'E', 'D', 'Ms.', 'VIDYA', '', 'MARKANDEY', 1, 64, 24, 237, 263, '9340634134', 'vidyamarkandey.vspl@gmail.com', 'F', 'N', 'N', 14, '2019-02-25', '2021-03-17', '303391', NULL),
(717, 839, 'E', 'D', 'Mr.', 'MAKANI', '', 'RAMAKRISHNA', 1, 66, 6, 68, 220, '9603960349', 'mramakrishna.vspl@gmail.com', 'M', 'Y', 'N', 53, '2019-03-01', '2021-05-12', '594878', NULL),
(718, 840, 'E', 'A', 'Mr.', 'JAGADISHA', '', 'K', 1, 69, 6, 67, 531, '9448991433', 'jagadisha.k@vnrseeds.com', 'M', 'Y', 'N', 77, '2019-03-01', NULL, '1355124', NULL),
(719, 841, 'E', 'A', 'Mr.', 'AMIT', '', 'KUMAR', 1, 73, 3, 602, 51, '9811332133', 'amit.upadhyay@vnrseeds.com', 'M', 'Y', 'N', 1, '2019-03-02', NULL, '3957000', NULL),
(720, 842, 'E', 'A', 'Mr.', 'TRISHANK', '', 'VERMA', 1, 64, 24, 237, 382, '7354030711', 'trishankverma.vspl@gmail.com', 'M', 'N', 'N', 235, '2019-03-05', NULL, '339539', NULL),
(721, 843, 'E', 'A', 'Mr.', 'SURESH', 'KUMAR', 'SHUKLA', 1, 61, 5, 125, 246, '6266958133', 'sureshshukla.vspl@gmail.com', 'M', 'Y', 'N', 14, '2019-03-05', NULL, '263448', NULL),
(722, 844, 'E', 'A', 'Mr.', 'RAJPUT', 'TEJBHAN', 'HAUSHILABAKSH SINGH', 1, 62, 5, 609, 54, '8160550549', 'rajputtejbhan.vspl@gmail.com', 'M', 'Y', 'N', 14, '2019-03-05', NULL, '269036', NULL),
(723, 845, 'E', 'A', 'Mr.', 'CHANDAN ', 'KUMAR', 'CHOUDHARY', 1, 66, 6, 68, 34, '9712812362', 'chandanchoudhary.vspl@gmail.com', 'M', 'Y', 'N', 169, '2019-03-07', NULL, '615434', NULL),
(724, 846, 'E', 'D', 'Ms.', 'MANYA', '', 'TRIPATHI', 1, 63, 1, 317, 182, '8719036329', 'manya.tripathi@vnrseeds.com', 'F', 'N', 'N', 1, '2019-03-12', '2019-06-17', '226960', NULL),
(725, 847, 'E', 'A', 'Mr.', 'DHARMENDRA', '', 'UPADHYAY', 1, 63, 6, 254, 924, '9644882667', 'dharmendraupadhyay.vspl@gmail.com', 'M', 'Y', 'N', 252, '2019-04-01', NULL, '355151', NULL),
(726, 848, 'E', 'A', 'Mr.', 'PANKAJ', '', 'KUMAR', 1, 69, 6, 67, 531, '7903329316', 'pankaj.kumar@vnrseeds.com', 'M', 'Y', 'N', 168, '2019-04-12', NULL, '1722785', NULL),
(727, 10001, 'E', 'A', 'Mr.', 'RAHUL', '', 'TRIPATHI', 3, 45, 19, 403, 0, '9981995388', 'RAHUL.TRIPATHI@VNRSEEDS.COM', 'M', 'N', 'N', 103, '2008-12-01', NULL, '0', NULL),
(728, 849, 'E', 'D', 'Mr.', 'ROHAN', 'MARUTI', 'PATIL', 1, 65, 6, 255, 913, '8888467050', 'rohanmarutipatil.vspl@gmail.com', 'M', 'N', 'N', 166, '2019-04-15', '2021-03-15', '427991', NULL),
(729, 850, 'E', 'A', 'Ms.', 'RUCHI', '', '.', 1, 65, 12, 348, 417, '9506385575', 'ruchi.vspl@gmail.com', 'F', 'N', 'N', 1, '2019-04-15', NULL, '468622', NULL),
(730, 851, 'E', 'A', 'Mr.', 'AVINASH', 'KUMAR', 'RAJBHAR', 1, 63, 25, 217, 416, '9305071893', 'avinashkrajbhar.vspl@gmail.com', 'M', 'Y', 'N', 9, '2019-04-16', NULL, '385967', NULL),
(731, 852, 'E', 'A', 'Mr.', 'VINAY', 'KUMAR', 'SINGH', 1, 69, 6, 67, 399, '9575947111', 'vinaykumar.singh@vnrseeds.com', 'M', 'Y', 'N', 4, '2019-05-03', NULL, '1654123', NULL),
(732, 853, 'E', 'A', 'Mr.', 'G', '', 'SWAPNIL', 1, 66, 12, 490, 51, '9752485859', 'g.swapnil@vnrseeds.com', 'M', 'Y', 'N', 1, '2019-05-03', NULL, '621447', NULL),
(733, 854, 'E', 'A', 'Mr.', 'LAXMIKANT', 'SHRIKISHANJI', 'VARMA', 1, 68, 2, 439, 601, '8392981221', 'laxmikants.varma@vnrseeds.com', 'M', 'Y', 'N', 1, '2019-05-06', NULL, '843806', NULL),
(734, 855, 'E', 'A', 'Mr.', 'ALOK', 'KUMAR', 'YADAV', 1, 63, 25, 217, 366, '9415907942', 'alokkumaryadav.vspl@gmail.com', 'M', 'Y', 'N', 14, '2019-05-06', NULL, '394007', NULL),
(735, 856, 'E', 'A', 'Mr.', 'OM', '', 'PRAKASH', 1, 66, 6, 68, 731, '9838554322', 'omprakash.vspl@gmail.com', 'M', 'Y', 'N', 70, '2019-05-06', NULL, '1102183', NULL),
(736, 857, 'E', 'A', 'Mr.', 'SHAIK', '', 'AZAHARUDDIN', 1, 65, 6, 255, 597, '7729824049', 'shaikazaharuddin.vspl@gmail.com', 'M', 'N', 'N', 72, '2019-05-13', NULL, '535407', NULL),
(737, 858, 'E', 'A', 'Ms.', 'NEELAM', '', 'TANDON', 1, 65, 11, 106, 224, '9111124237', 'neelam.tandon@vnrseeds.com', 'F', 'N', 'N', 15, '2019-05-13', NULL, '494099', NULL),
(738, 859, 'E', 'D', 'Mr.', 'VIVEK', 'KUMAR', 'VERMA', 1, 67, 2, 5, 179, '8199997472', '', 'M', 'Y', 'N', 1, '2019-05-14', '2019-05-18', '550081', NULL),
(739, 860, 'E', 'A', 'Mr.', 'VIPIN', '', 'GUJJAR', 1, 65, 6, 255, 726, '7895824999', 'vipingujjar.vspl@gmail.com', 'M', 'Y', 'N', 226, '2019-05-20', NULL, '670143', NULL),
(740, 861, 'E', 'D', 'Mr.', 'PUSHKAR', '', 'KAUSHIK', 1, 64, 3, 285, 15, '9719074656', 'pushkarkaushik.vspl@gmail.com', 'M', 'N', 'N', 23, '2019-05-20', '2020-08-08', '374579', NULL),
(741, 862, 'E', 'D', 'Mr.', 'VIKAS', '', 'YADAV', 1, 62, 3, 493, 321, '8299086889', 'vikasyadav.vspl@gmail.com', 'M', 'N', 'N', 7, '2019-05-27', '2020-07-31', '243698', NULL),
(742, 863, 'E', 'A', 'Mr.', 'TAPAN', 'KUMAR ', 'ROUT', 1, 66, 6, 68, 375, '9692788088', 'tapanrout.vspl@gmail.com', 'M', 'N', 'N', 189, '2019-05-27', NULL, '766233', NULL),
(743, 864, 'E', 'D', 'Mr.', 'PATHAKOTTU', 'SAI NAG', 'REDDY', 1, 65, 6, 492, 14, '8096181358', 'psainag.vspl@gmail.com', 'M', 'N', 'N', 51, '2019-05-27', '2020-02-25', '650104', NULL),
(744, 865, 'E', 'D', 'Mr.', 'SANDEEP', 'KUMAR ', 'GUPTA', 1, 63, 3, 215, 780, '7800990004', 'sandeepkgupta.vspl@gmail.com', 'M', 'Y', 'N', 70, '2019-05-28', NULL, '368723', NULL),
(745, 866, 'E', 'A', 'Mr.', 'VISHAL', '', 'MANDIYA', 1, 64, 7, 207, 28, '9755442734', 'vishalmandiya.vspl@gmail.com', 'M', 'Y', 'N', 1, '2019-06-01', NULL, '345575', NULL),
(746, 867, 'E', 'A', 'Mr.', 'NANDAN', 'KUMAR', 'SINGH', 1, 66, 6, 68, 4, '9793107505', 'nandankumarsingh.vspl@gmail.com', 'M', 'Y', 'N', 291, '2019-06-03', NULL, '692736', NULL),
(747, 868, 'E', 'D', 'Mr.', 'SAURABH', 'KUMAR ', 'MISHRA', 1, 64, 3, 608, 143, '9554379693', 'saurabhkmishra.vspl@gmail.com', 'M', 'N', 'N', 37, '2019-06-05', '2021-08-02', '330095', NULL),
(748, 869, 'E', 'A', 'Mr.', 'ALOK', 'KUMAR', 'SINGH', 1, 67, 2, 5, 1078, '9140026452', 'alokkumar.singh@vnrseeds.com', 'M', 'N', 'N', 7, '2019-06-10', NULL, '650900', NULL),
(749, 870, 'E', 'D', 'Mr.', 'Y', '', 'VASANTH', 1, 67, 2, 5, 1078, '9553655355', 'y.vasanth@vnrseeds.com', 'M', 'N', 'N', 1, '2019-06-10', '2020-07-18', '564494', NULL),
(750, 871, 'E', 'A', 'Mr.', 'PARMINDER', '', 'SINGH', 1, 67, 2, 5, 89, '9464485944', 'parminder.singh@vnrseeds.com', 'M', 'N', 'N', 7, '2019-06-12', NULL, '617912', NULL),
(751, 872, 'E', 'D', 'Ms.', 'KAVITA', '', 'NEGI', 1, 66, 2, 261, 601, '9636365432', 'kavita.negi@vnrseeds.com', 'F', 'N', 'N', 1, '2019-06-12', '2019-06-20', '400254', NULL),
(752, 873, 'E', 'D', 'Mr.', 'AJAY', 'KUMAR', 'TIWARI', 1, 63, 9, 202, 169, '9039964613', '', 'M', 'Y', 'N', 1, '2019-06-25', '2019-11-24', '380454', NULL),
(753, 874, 'E', 'A', 'Mr.', 'AWADH', '', 'RAM', 1, 61, 25, 124, 224, '7869118461', 'awadhram.vspl@gmail.com', 'M', 'Y', 'N', 15, '2019-06-25', NULL, '300983', NULL),
(754, 875, 'E', 'A', 'Mr.', 'BANSHI', 'DHAR', 'SHARMA', 1, 65, 3, 607, 321, '9828853819', 'banshidharsharma.vspl@gmail.com', 'M', 'Y', 'N', 37, '2019-06-26', NULL, '813297', NULL),
(755, 876, 'E', 'D', 'Mr.', 'ANKUSH', '', 'HIWASE', 1, 63, 3, 215, 143, '9913175230', 'ankushhiwase.vspl@gmail.com', 'M', 'N', 'N', 132, '2019-07-06', '2020-08-10', '331955', NULL),
(756, 35, 'E', 'D', 'Mr.', 'SACHIN', '', 'PATEL', 3, 31, 21, 433, 410, '9182249207', '', 'M', 'N', 'N', 237, '2019-07-05', NULL, '322355', NULL),
(757, 36, 'E', 'A', 'Mr.', 'SHUBHAM', '', 'VISHWAKARMA', 3, 31, 21, 623, 410, '8109277142', 'shubham.vnrnursery@gmail.com', 'M', 'N', 'N', 102, '2019-07-05', NULL, '408145', NULL),
(758, 37, 'E', 'D', 'Mr.', 'FAREED ', 'UDDIN', 'SIDDIQUI', 3, 31, 19, 411, 445, '9670410877', '', 'M', 'N', 'N', 102, '2019-07-05', '2019-08-19', '322355', NULL),
(759, 877, 'E', 'D', 'Mr.', 'HEMCHAND', '', 'K', 1, 69, 9, 321, 461, '9840434334', 'hemchand.k@vnrseeds.com', 'M', 'Y', 'N', 1, '2019-07-12', '2021-04-08', '1599229', NULL),
(760, 878, 'E', 'A', 'Mr.', 'SUDHANSU', 'SEKHAR', 'SWAIN', 1, 66, 3, 606, 927, '9078000139', 'sudhansusswain.vspl@gmail.com', 'M', 'Y', 'N', 179, '2019-07-15', NULL, '715991', NULL),
(761, 879, 'E', 'A', 'Mr.', 'GAMMINGI', 'SOLOMON', 'RAJ', 1, 67, 2, 5, 89, '9885680741', 'gsolomon.raj@vnrseeds.com', 'M', 'N', 'N', 1, '2019-07-19', NULL, '622625', NULL),
(762, 880, 'E', 'A', 'Ms.', 'ARUSHI', '', 'DUTTA', 1, 64, 1, 301, 182, '8871272008', 'arushi.dutta@vnrseeds.com', 'F', 'N', 'N', 1, '2019-08-02', NULL, '354779', NULL),
(763, 881, 'E', 'D', 'Ms.', 'RICHA', '', 'DHYANI', 1, 67, 2, 5, 89, '8958031452', 'richadhyani25@gmail.com', 'F', 'N', 'N', 1, '2019-08-05', '2020-03-07', '540354', NULL),
(764, 882, 'E', 'D', 'Mr.', 'ABHISHEK ', '', 'MISHRA', 1, 64, 6, 257, 4, '8953837262', 'abhishekmishra.vspl@gmail.com', 'M', 'N', 'N', 97, '2019-08-23', '2020-09-11', '365195', NULL),
(765, 883, 'E', 'A', 'Mr.', 'ANIL ', 'KUMAR', ' GANGWAR', 1, 64, 6, 257, 261, '9758950034', 'anilgangwar.vspl@gmail.com', 'M', 'N', 'N', 109, '2019-08-23', NULL, '414698', NULL),
(766, 884, 'E', 'D', 'Mr.', 'ANKIT', '', ' SINGH', 1, 64, 6, 257, 4, '8318711049', 'ankitsinghb.vspl@gmail.com', 'M', 'N', 'N', 137, '2019-08-23', '2020-09-22', '365195', NULL),
(767, 885, 'E', 'A', 'Mr.', 'ASHISH', ' KUMAR', ' GUPTA', 1, 64, 6, 257, 584, '8273598120', 'ashishgupta.vspl@gmail.com', 'M', 'N', 'N', 203, '2019-08-23', NULL, '440126', NULL),
(768, 886, 'E', 'A', 'Mr.', 'DEEPAK ', '', 'GANGWAR', 1, 64, 6, 257, 11, '9457744772', 'deepakgangwar.vspl@gmail.com', 'M', 'N', 'N', 101, '2019-08-23', NULL, '404807', NULL),
(769, 887, 'E', 'A', 'Mr.', 'DURGENDRA', ' PRATAP ', 'SINGH', 1, 64, 6, 257, 252, '9721689385', 'durgendrapsingh.vspl@gmail.com', 'M', 'N', 'N', 251, '2019-08-23', NULL, '447183', NULL),
(770, 888, 'E', 'A', 'Mr.', 'RAJ ', '', 'BAIRAGI', 1, 64, 6, 257, 438, '9506952387', 'rajbairagi.vspl@gmail.com', 'M', 'N', 'N', 95, '2019-08-23', NULL, '451085', NULL),
(771, 889, 'E', 'D', 'Mr.', 'TARUN ', '', 'MISHRA', 1, 64, 6, 257, 4, '7417731866', 'tarunmishra.vspl@gmail.com', 'M', 'N', 'N', 67, '2019-08-23', '2020-12-10', '365195', NULL),
(772, 890, 'E', 'D', 'Mr.', 'VIVEK ', '', 'JHA', 1, 64, 6, 257, 4, '8076083875', 'vivekjha.vspl@gmail.com', 'M', 'N', 'N', 268, '2019-08-23', '2021-02-07', '365195', NULL),
(773, 891, 'E', 'A', 'Mr.', 'VIVEK', ' PRATAP ', 'SINGH', 1, 64, 6, 257, 584, '8423984951', 'vivekpratapsingh.vspl@gmail.com', 'M', 'N', 'N', 64, '2019-08-23', NULL, '417177', NULL),
(774, 892, 'E', 'A', 'Mr.', 'BISWA', 'BHUSAN', 'MAHAKUL', 1, 65, 6, 255, 375, '9337978734', 'biswabhusan.vspl@gmail.com', 'M', 'N', 'N', 293, '2019-08-28', NULL, '499658', NULL),
(775, 893, 'E', 'A', 'Mr.', 'ROHIT', '', 'MANDAL', 1, 64, 24, 237, 294, '9340161400', 'rohitmandal.vspl@gmail.com', 'M', 'N', 'N', 14, '2019-09-05', NULL, '367055', NULL),
(776, 894, 'E', 'D', 'Mr.', 'AKHLESH', 'KUMAR ', 'JAISWAL', 1, 65, 2, 7, 345, '8982319211', '', 'M', 'N', 'N', 261, '2019-09-10', '2019-10-04', '347195', NULL),
(777, 895, 'E', 'D', 'Mr.', 'RAJESH', '', 'MAHAJAN', 1, 65, 2, 7, 414, '7587832567', '', 'M', 'N', 'N', 261, '2019-09-10', '2019-10-04', '347195', NULL),
(778, 896, 'E', 'A', 'Mr.', 'SUJEET', 'KUMAR', 'SINGH', 1, 71, 4, 370, 35, '9009129070', 'sujeet.singh@vnrseeds.com', 'M', 'Y', 'N', 1, '2019-09-10', NULL, '3187096', NULL),
(779, 897, 'E', 'A', 'Mr.', 'RAJENDRA', '', 'PRASAD', 1, 70, 4, 427, 778, '6260186370', 'rajendra.prasad@vnrseeds.com', 'M', 'Y', 'N', 1, '2019-09-10', NULL, '1732504', NULL),
(780, 898, 'E', 'A', 'Mr.', 'ANKUSH', 'KUMAR', 'SINGH', 1, 65, 3, 607, 321, '8896448996', 'ankushkrsingh.vspl@gmail.com', 'M', 'N', 'N', 45, '2019-09-13', NULL, '501315', NULL),
(781, 899, 'E', 'D', 'Mr.', 'ANJAY', '', 'KUMAR', 1, 63, 3, 287, 321, '8604843196', 'anjaykumar.vspl@gmail.com', 'M', 'N', 'N', 2, '2019-09-13', '2020-07-15', '347195', NULL),
(782, 900, 'E', 'A', 'Mr.', 'SATHIGARI', 'VENUGOPAL', 'REDDY', 1, 64, 3, 608, 238, '8555834571', 'sathigarivenugopal.vspl@gmail.com', 'M', 'N', 'N', 306, '2019-09-13', NULL, '470721', NULL),
(783, 901, 'E', 'D', 'Mr.', 'YOGESH', 'RAJKUMAR', 'MURGUNDI', 1, 63, 3, 287, 238, '8762327721', 'yogeshrajkumar.vspl@gmail.com', 'M', 'N', 'N', 217, '2019-09-13', '2021-06-07', '438960', NULL),
(784, 902, 'E', 'D', 'Mr.', 'GAUTAM', 'KUMAR', 'GOIT', 1, 63, 3, 287, 143, '7903358925', 'gautamgoit.vspl@gmail.com', 'M', 'N', 'N', 37, '2019-09-13', '2020-01-13', '347195', NULL),
(785, 903, 'E', 'A', 'Mr.', 'SHELENDRA ', '', 'RAGHUWANSHI', 1, 64, 3, 608, 927, '9839512261', 'shelendraraghuwanshi.vspl@gmail.com', 'M', 'N', 'N', 268, '2019-09-13', NULL, '385571', NULL),
(786, 904, 'E', 'A', 'Mr.', 'ARVIND', '', '.', 1, 64, 3, 608, 927, '8305336471', 'arvindchoudhary.vspl@gmail.com', 'M', 'N', 'N', 66, '2019-09-13', NULL, '383315', NULL),
(787, 905, 'E', 'A', 'Mr.', 'MOHIT', '', 'SANWAL', 1, 64, 3, 608, 15, '7891661666', 'mohitsanwal.vspl@gmail.com', 'M', 'Y', 'N', 101, '2019-09-13', NULL, '452202', NULL),
(788, 906, 'E', 'A', 'Mr.', 'ABHIJEET ', '', 'KUMAR', 1, 63, 3, 287, 15, '7379033267', 'abhijeet.vspl@gmail.com', 'M', 'N', 'N', 2, '2019-09-13', NULL, '378791', NULL),
(789, 907, 'E', 'A', 'Mr.', 'MORAMPUDI', 'SAI', 'NAVEEN', 1, 64, 4, 306, 359, '9494259479', 'msainaveen.vspl@gmail.com', 'M', 'N', 'N', 22, '2019-09-16', NULL, '282256', NULL),
(790, 908, 'E', 'A', 'Mr.', 'BISHNU', 'RAM', 'SAHU', 1, 64, 4, 306, 793, '9399125145', 'bishnuramsahu.vspl@gmail.com', 'M', 'Y', 'N', 31, '2019-09-17', NULL, '649857', NULL),
(791, 909, 'E', 'A', 'Mr.', 'DURGESH', '', '.', 1, 64, 4, 306, 793, '7978698718', 'durgesh.vspl@gmail.com', 'M', 'Y', 'N', 358, '2019-09-17', NULL, '597173', NULL),
(792, 910, 'E', 'A', 'Mr.', 'YOGESHWAR', '', 'SAHU', 1, 64, 4, 306, 793, '9754245770', 'yogeshwarsahu.vspl@gmail.com', 'M', 'Y', 'N', 265, '2019-09-17', NULL, '531787', NULL),
(793, 911, 'E', 'A', 'Mr.', 'DURGESH', 'PRATAP', 'SINGH', 1, 69, 4, 371, 778, '8120045902', 'durgeshprataps.vspl@gmail.com', 'M', 'Y', 'N', 31, '2019-09-17', NULL, '1221346', NULL),
(794, 912, 'E', 'A', 'Mr.', 'AVINASH', '', 'PANDEY', 1, 64, 4, 306, 845, '9721716568', 'avinashpandey.vspl@gmail.com', 'M', 'N', 'N', 118, '2019-09-23', NULL, '312263', NULL),
(795, 913, 'E', 'A', 'Mr.', 'SANJAY', '', 'JAT', 1, 65, 4, 306, 359, '9111713507', 'sanjayjat.vspl@gmail.com', 'M', 'N', 'N', 392, '2019-09-23', NULL, '358715', NULL),
(796, 914, 'E', 'A', 'Mr.', 'SAMBIT', '', 'PADHI', 1, 64, 4, 306, 667, '8328998657', 'sambitpadhi.vspl@gmail.com', 'M', 'N', 'N', 242, '2019-09-23', NULL, '313571', NULL),
(797, 915, 'E', 'A', 'Mr.', 'RAJNEESH', '', 'VERMA', 1, 64, 4, 306, 793, '7052780017', 'rajneeshverma.vspl@gmail.com', 'M', 'N', 'N', 31, '2019-09-23', NULL, '250897', NULL),
(798, 916, 'E', 'A', 'Mr.', 'SOHIT', '', 'PAL', 1, 64, 4, 306, 667, '7895316768', 'sohitpal.vspl@gmail.com', 'M', 'N', 'N', 242, '2019-09-23', NULL, '353123', NULL),
(799, 917, 'E', 'A', 'Mr.', 'LOVE ', '', 'KUMAR', 1, 64, 4, 306, 362, '9568425323', 'lovekumar.vspl@gmail.com', 'M', 'Y', 'N', 22, '2019-09-23', NULL, '461590', NULL),
(800, 918, 'E', 'A', 'Mr.', 'ACHE', '', 'RAMANNA', 1, 62, 4, 226, 359, '8978028215', '', 'M', 'Y', 'N', 22, '2019-09-25', NULL, '262752', NULL),
(801, 919, 'E', 'A', 'Mr.', 'BETHU', 'PRAVEEN', 'KUMAR', 1, 62, 4, 226, 362, '8978028215', '', 'M', 'Y', 'N', 22, '2019-09-25', NULL, '267336', NULL),
(802, 920, 'E', 'A', 'Mr.', 'YANTRAPATI', '', 'RAMESH', 1, 63, 4, 592, 359, '7780311753', '', 'M', 'Y', 'N', 229, '2019-09-25', NULL, '318935', NULL),
(803, 921, 'E', 'A', 'Mr.', 'KOTA', '', 'SRINIVAS', 1, 62, 4, 226, 359, '8008094993', '', 'M', 'Y', 'N', 22, '2019-09-25', NULL, '302291', NULL),
(804, 922, 'E', 'A', 'Mr.', 'MALA', '', 'PARANDAMA', 1, 61, 2, 249, 849, '9542712979', '', 'M', 'N', 'N', 7, '2019-09-25', NULL, '192544', NULL),
(805, 923, 'E', 'A', 'Mr.', 'DIGOO', 'PRASAD', 'SINHA', 1, 63, 4, 226, 845, '9111910690', 'diggoprasadsinha.vspl@gmail.com', 'M', 'Y', 'N', 118, '2019-10-01', NULL, '333275', NULL),
(806, 924, 'E', 'A', 'Mr.', 'SUKHDEV', 'GIRI', 'GOSWAMI', 1, 62, 4, 226, 845, '7771066082', 'sukhdevgoswami.vspl@gmail.com', 'M', 'N', 'N', 118, '2019-10-01', NULL, '201754', NULL),
(807, 925, 'E', 'A', 'Mr.', 'DEEPAK ', '', 'KUMAR', 1, 64, 4, 595, 793, '6394197103', 'deepakkgour.vspl@gmail.com', 'M', 'Y', 'N', 266, '2019-10-01', NULL, '403960', NULL),
(808, 926, 'E', 'A', 'Mr.', 'RATNESH', 'KUMAR', 'SHUKLA', 1, 64, 4, 306, 793, '9755657633', 'ratneshshukla.vspl@gmail.com', 'M', 'N', 'N', 31, '2019-10-01', NULL, '250724', NULL),
(809, 927, 'E', 'D', 'Mr.', 'GIRDHARI', '', ' PATELIYA', 1, 63, 25, 169, 361, '8790592843', 'girdharipateliya.vspl@gmail.com', 'M', 'N', 'N', 118, '2019-10-10', '2020-10-17', '282056', NULL),
(810, 928, 'E', 'A', 'Mr.', 'RAVISH', 'KUMAR', 'MISHRA', 1, 66, 4, 373, 850, '8309534750', 'ravishkrmishra.vspl@gmail.com', 'M', 'Y', 'N', 263, '2019-10-10', NULL, '527688', NULL),
(811, 929, 'E', 'A', 'Mr.', 'AMRISH', 'KUMAR', 'VERMA', 1, 65, 2, 7, 414, '7309588644', 'amrishverma.vspl@gmail.com', 'M', 'N', 'N', 261, '2019-10-10', NULL, '387599', NULL),
(812, 930, 'E', 'A', 'Mr.', 'DOMESH', '', 'SAHU', 1, 62, 25, 31, 266, '9977877235', '', 'M', 'Y', 'N', 118, '2019-10-10', NULL, '253586', NULL),
(813, 931, 'E', 'A', 'Mr.', 'SAHADEV', '', 'KUMAWAT', 1, 65, 2, 7, 931, '8349699677', 'sahadevkumawat.vspl@gmail.com', 'M', 'N', 'N', 261, '2019-10-10', NULL, '391859', NULL),
(814, 932, 'E', 'A', 'Mr.', 'SHEKHAR', '', 'SHARMA', 1, 65, 2, 7, 345, '7084584071', 'shekharsharma.vspl@gmail.com', 'M', 'Y', 'N', 1, '2019-10-10', NULL, '391859', NULL),
(815, 933, 'E', 'A', 'Mr.', 'NILMANI', '', 'SAHU', 1, 64, 4, 595, 790, '8889399741', '', 'M', 'Y', 'N', 31, '2019-10-10', NULL, '301691', NULL),
(816, 934, 'E', 'A', 'Mr.', 'NANHE', '', 'GOND', 1, 63, 4, 592, 793, '7772029802', '', 'M', 'Y', 'N', 251, '2019-10-10', NULL, '235058', NULL),
(817, 935, 'E', 'A', 'Mr.', 'VASPARI', '', 'KISHORE', 1, 63, 4, 226, 145, '9949268344', '', 'M', 'Y', 'N', 129, '2019-10-10', NULL, '315047', NULL),
(818, 936, 'E', 'A', 'Mr.', 'SAMPANGI', '', 'PARMESHWAR', 1, 63, 4, 226, 145, '9912875482', '', 'M', 'Y', 'N', 99, '2019-10-10', NULL, '326663', NULL),
(819, 937, 'E', 'A', 'Mr.', 'B', 'NIRANJAN', 'NAIDU', 1, 63, 4, 226, 145, '9553789344', '', 'M', 'Y', 'N', 267, '2019-10-10', NULL, '307727', NULL),
(820, 938, 'E', 'A', 'Mr.', 'RAJEEV', '', 'KUMAR', 1, 68, 4, 156, 362, '7702579871', 'rajeevkumar.vspl@gmail.com', 'M', 'Y', 'N', 22, '2019-10-11', NULL, '999969', NULL),
(821, 939, 'E', 'A', 'Mr.', 'VEERENDRA', 'PAL', 'SINGH', 1, 69, 4, 371, 362, '9701709241', 'veerendrapsingh.vspl@gmail.com', 'M', 'Y', 'N', 22, '2019-10-11', NULL, '1716563', NULL),
(822, 940, 'E', 'A', 'Mr.', 'KAILASH ', 'CHANDRA', 'MALLICK', 1, 64, 4, 595, 850, '7381119047', '', 'M', 'Y', 'N', 263, '2019-10-11', NULL, '299075', NULL),
(823, 941, 'E', 'D', 'Mr.', 'BIJAYA', 'KUMAR', 'JENA', 1, 62, 4, 226, 850, '9439242283', '', 'M', 'Y', 'N', 263, '2019-10-11', '2020-10-21', '262878', NULL),
(824, 942, 'E', 'A', 'Mr.', 'MALLIKARJUNARAO', '', 'VANGALLI', 1, 62, 4, 226, 145, '9573427351', '', 'M', 'Y', 'N', 267, '2019-10-12', NULL, '298295', NULL),
(825, 943, 'E', 'A', 'Mr.', 'BOYA MAHENDRA', '', 'NAYADU', 1, 62, 4, 226, 145, '8074688775', '', 'M', 'N', 'N', 99, '2019-10-12', NULL, '276358', NULL),
(826, 944, 'E', 'A', 'Mr.', 'GORAKH', '', 'PRASAD', 1, 64, 4, 306, 362, '9704789503', 'gorakhprasad.vspl@gmail.com', 'M', 'Y', 'N', 22, '2019-10-15', NULL, '504236', NULL),
(827, 945, 'E', 'A', 'Mr.', 'AJAY', '', 'VERMA', 1, 64, 24, 237, 294, '9118846684', 'ajayvermaqa.vspl@gmail.com', 'M', 'Y', 'N', 1, '2019-10-16', NULL, '377003', NULL),
(828, 947, 'E', 'A', 'Mr.', 'GUDALA', '', 'VINAY', 1, 63, 4, 592, 821, '9949462704', '', 'M', 'Y', 'N', 22, '2019-10-21', NULL, '346511', NULL),
(829, 946, 'E', 'A', 'Mr.', 'VELMAREDDY', '', 'MADHUKAR', 1, 64, 4, 306, 821, '8008753299', 'velmareddymadhukar.vspl@gmail.com', 'M', 'N', 'N', 22, '2019-10-21', NULL, '449784', NULL),
(830, 948, 'E', 'A', 'Mr.', 'MUDURUKOLLA', '', 'KUMAR', 1, 63, 4, 592, 821, '9676748047', '', 'M', 'Y', 'N', 22, '2019-10-21', NULL, '305507', NULL),
(831, 949, 'E', 'D', 'Mr.', 'GUNDEKARI', '', 'SUMAN', 1, 62, 4, 226, 821, '9618564283', 'suman.gvnr@gmail.com', 'M', 'Y', 'N', 22, '2019-10-21', '2020-12-15', '257377', NULL),
(832, 950, 'E', 'D', 'Mr.', 'ANDRA', '', 'RAMANAIDU', 1, 66, 4, 228, 145, '9449552327', 'andraramanaidu.vspl@gmail.com', 'M', 'Y', 'N', 129, '2019-10-21', '2019-12-07', '550023', NULL),
(833, 38, 'E', 'A', 'Mr.', 'ROHIT', '', 'RAI', 3, 31, 19, 624, 445, '9084861380', 'rohit.vnrnursery@gmail.com', 'M', 'N', 'N', 102, '2019-10-16', NULL, '418355', NULL),
(834, 39, 'E', 'A', 'Mr.', 'PRIYA ', 'DARSHAN ', 'DEWAN', 3, 31, 19, 624, 445, '7797253186', 'priyadarshan.vnrnursery@gmail.com', 'M', 'N', 'N', 102, '2019-10-16', NULL, '418355', NULL),
(835, 951, 'E', 'A', 'Mr.', 'POREDDY', '', 'JANARDHAN', 1, 66, 4, 373, 362, '9000242626', 'poreddyjanardhan.vspl@gmail.com', 'M', 'Y', 'N', 22, '2019-10-21', NULL, '869000', NULL),
(836, 952, 'E', 'D', 'Mr.', 'NAGELLI SUDHAKER', '', 'REDDY', 1, 64, 4, 306, 362, '8497975380', 'nsudhakarreddy.vspl@gmail.com', 'M', 'N', 'N', 22, '2019-11-01', '2020-11-30', '296707', NULL),
(837, 953, 'E', 'D', 'Mr.', 'YALCHALA MAHENDAR', '', 'REDDY', 1, 64, 4, 306, 359, '9908278798', 'ymahendarreddy.vspl@gmail.com', 'M', 'Y', 'N', 229, '2019-11-02', '2020-08-28', '411395', NULL),
(838, 954, 'E', 'A', 'Mr.', 'SHAIK ABDUL', 'RAHMAN', 'ASAD', 1, 65, 4, 306, 820, '9949928817', 'abdulrahman.vspl@gmail.com', 'M', 'Y', 'N', 22, '2019-11-11', NULL, '443955', NULL),
(839, 955, 'E', 'A', 'Mr.', 'JITENDRA', '', 'JAISWAL', 1, 67, 4, 372, 845, '9893219117', 'jitendrajaiswal.vspl@gmail.com', 'M', 'Y', 'N', 118, '2019-11-13', NULL, '803136', NULL),
(840, 956, 'E', 'A', 'Mr.', 'PARTHASARATHI', '', 'SAMAL', 1, 62, 27, 482, 354, '9776058152', '', 'M', 'Y', 'N', 242, '2019-11-13', NULL, '337451', NULL),
(841, 957, 'E', 'D', 'Dr.', 'SHAILESH', '', 'KUMAR', 1, 70, 2, 2, 7, '7060114447', 'Shailesh.kumar@vnrseeds.com', 'M', 'Y', 'Y', 12, '2019-11-13', '2020-10-10', '2184002', NULL),
(842, 958, 'E', 'A', 'Mr.', 'ABHIMANYU', 'KUMAR', 'MISHRA', 1, 64, 4, 306, 850, '8936895440', 'abhimanyumishra.vspl@gmail.com', 'M', 'N', 'N', 263, '2019-11-21', NULL, '322787', NULL),
(843, 959, 'E', 'D', 'Mr.', 'SANGI', '', 'SAMMAIAH', 1, 62, 4, 226, 821, '9676531276', '', 'M', 'Y', 'N', 22, '2019-11-27', '2020-01-17', '221684', NULL),
(844, 960, 'E', 'A', 'Mr.', 'GURU PRASAD', '', 'BARAL', 1, 64, 4, 306, 850, '8018743140', 'guruprasadbaral.vspl@gmail.com', 'M', 'N', 'N', 263, '2019-12-10', NULL, '415987', NULL),
(845, 961, 'E', 'A', 'Mr.', 'RAGHUBANSH', 'MANI', 'SINGH', 1, 69, 4, 371, 779, '8120985120', 'raghubanshmani.singh@vnrseeds.com', 'M', 'Y', 'N', 118, '2019-12-16', NULL, '1147590', NULL),
(846, 962, 'E', 'A', 'Mr.', 'RAM', '', 'PRAVESH', 1, 65, 2, 7, 89, '8303245768', 'rampravesh.vspl@gmail.com', 'M', 'N', 'N', 261, '2019-12-17', NULL, '385595', NULL),
(847, 963, 'E', 'D', 'Dr.', 'MAYUR', 'RAVINDRA', 'WALLALWAR', 1, 67, 2, 439, 65, '7987902141', 'mayurwallalwar@vnrseeds.com', 'M', 'N', 'Y', 1, '2019-12-30', '2020-03-06', '600101', NULL),
(848, 964, 'E', 'A', 'Mr.', 'ANANDRAJ', 'SANDEEP', 'PARDHI', 1, 63, 5, 57, 246, '7999699091', 'anandrajparidhi.vspl@gmail.com', 'M', 'N', 'N', 14, '2020-01-02', NULL, '255803', NULL),
(849, 965, 'E', 'A', 'Dr.', 'PANGA', 'RAVI', 'YUGANDHAR', 1, 68, 2, 5, 7, '9502471491', 'raviyugandhar@vnrseeds.com', 'M', 'Y', 'Y', 7, '2020-01-02', NULL, '807039', NULL),
(850, 966, 'E', 'A', 'Mr.', 'AJAY ', 'KUMAR', 'SINGH', 1, 69, 4, 371, 779, '9439511339', 'ajaykumar.singh@vnrseeds.com', 'M', 'Y', 'N', 34, '2020-01-02', NULL, '1475048', NULL),
(851, 967, 'E', 'A', 'Mr.', 'SHREEDHARA', '', 'H', 1, 61, 2, 249, 520, '9886807327', 'shreedhara.vnrseeds@gmail.com', 'M', 'N', 'N', 204, '2020-01-02', NULL, '226709', NULL),
(852, 968, 'E', 'A', 'Mr.', 'HARSH', 'BAHADUR', 'SINGH', 1, 64, 6, 257, 915, '6386716370', 'harshbahadur.vspl@gmail.com', 'M', 'N', 'N', 10, '2020-01-06', NULL, '435340', NULL),
(853, 879459, 'E', 'A', 'Mr.', 'AAKASH ', 'KUMAR ', 'MASRAM', 4, 46, 32, 502, 895, '9713401309', '', 'M', 'N', 'N', 273, '2013-01-28', NULL, '0', NULL),
(854, 1590056, 'E', 'A', 'Ms.', 'NIVEDITA', '', 'PAUL', 4, 46, 29, 500, 907, '9165797588', '', 'F', 'N', 'N', 273, '2019-04-01', NULL, '0', NULL),
(855, 1546529, 'E', 'D', 'Ms.', 'DEEPTI ', '', 'DEWANGAN', 4, 46, 32, 502, 895, '7999633774', '', 'F', 'N', 'N', 273, '2019-02-02', NULL, '0', NULL),
(856, 1646088, 'E', 'D', 'Ms.', 'SONALI ', '', 'PATEL', 4, 46, 29, 500, 906, '7987291260', '', 'F', 'N', 'N', 273, '2019-06-24', NULL, '0', NULL),
(857, 1590070, 'E', 'A', 'Ms.', 'FAGUN', '', 'JAISWAL', 4, 46, 29, 500, 907, '8109756484', '', 'F', 'N', 'N', 273, '2019-04-01', NULL, '0', NULL),
(858, 969, 'E', 'A', 'Mr.', 'AMIT', 'KUMAR', 'SINGH', 1, 65, 6, 255, 550, '8808354167', 'amitsingh.vspl@gmail.com', 'M', 'N', 'N', 74, '2020-01-13', NULL, '358079', NULL),
(859, 793249, 'E', 'D', 'Mr.', 'BANKE ', '', 'LAL', 4, 46, 33, 513, 889, '9030397256', '', 'M', 'N', 'N', 275, '2015-02-02', NULL, '0', NULL),
(860, 887334, 'E', 'A', 'Mr.', 'SUDIPTA', '', 'MUKHERJEE', 4, 46, 29, 501, 904, '0', '', 'M', 'N', 'N', 273, '2015-12-15', NULL, '0', NULL),
(861, 1316001, 'E', 'A', 'Mr.', 'RAVI', 'KUMAR', 'DEULKAR', 4, 46, 31, 512, 894, '9981361050', '', 'M', 'N', 'N', 273, '2018-01-08', NULL, '0', NULL),
(862, 1420355, 'E', 'D', 'Mr.', 'PRADEEP ', 'KUMAR', 'SAHU', 4, 46, 33, 507, 901, '0', '', 'M', 'N', 'N', 274, '2018-07-02', NULL, '0', NULL),
(863, 1420353, 'E', 'D', 'Mr.', 'KUMAR', '', 'YADAV', 4, 46, 33, 508, 901, '7828370945', '', 'M', 'N', 'N', 274, '2018-07-02', NULL, '0', NULL),
(864, 1641868, 'E', 'A', 'Mr.', 'LOV', 'KUMAR', 'DHIWAR', 4, 46, 35, 521, 892, '9009438450', '', 'M', 'N', 'N', 273, '2019-06-17', NULL, '0', NULL),
(865, 1449647, 'E', 'A', 'Mr.', 'POKHAN', '', 'SAHU', 4, 46, 30, 511, 896, '8103209703', '', 'M', 'N', 'N', 273, '2018-08-01', NULL, '0', NULL),
(866, 1008260, 'E', 'A', 'Mr.', 'MUKENDRA', '', 'KUMAR', 4, 46, 33, 505, 899, '9630205193', '', 'M', 'N', 'N', 274, '2016-05-02', NULL, '0', NULL),
(867, 1556210, 'E', 'A', 'Mr.', 'TULARAM', '', 'SAHU', 4, 46, 36, 517, 890, '0', '', 'M', 'N', 'N', 273, '2019-03-01', NULL, '0', NULL),
(868, 1556209, 'E', 'A', 'Mr.', 'NAGESH', 'KUMAR', 'SAHU', 4, 46, 36, 519, 890, '9993734198', '', 'M', 'N', 'N', 273, '2019-03-01', NULL, '0', NULL),
(869, 1556207, 'E', 'A', 'Mr.', 'KARAN', 'KUMAR', 'PATEL', 4, 46, 36, 520, 891, '8871712892', '', 'M', 'N', 'N', 273, '2019-03-01', NULL, '0', NULL),
(870, 1556208, 'E', 'A', 'Mr.', 'MANISH', 'KUMAR', 'FARIKAR', 4, 46, 36, 518, 890, '9752572229', '', 'M', 'N', 'N', 273, '2019-03-01', NULL, '0', NULL),
(871, 1556206, 'E', 'A', 'Mr.', 'BANTI', '', 'YADAV', 4, 46, 36, 520, 891, '9575229339', '', 'M', 'N', 'N', 273, '2019-03-01', NULL, '0', NULL),
(872, 1445325, 'E', 'D', 'Mr.', 'PRAMOD', 'KUMAR', 'SAHU', 4, 46, 33, 503, 898, '9575951099', '', 'M', 'N', 'N', 273, '2018-09-01', NULL, '0', NULL),
(873, 1420352, 'E', 'A', 'Mr.', 'TAMESHWAR', '', '.', 4, 46, 33, 509, 898, '7389997872', '', 'M', 'N', 'N', 274, '2018-07-02', NULL, '0', NULL),
(874, 1420356, 'E', 'A', 'Ms.', 'KHUSHBU', '', 'PASWAN', 4, 46, 33, 506, 900, '0', '', 'F', 'N', 'N', 274, '2018-07-02', NULL, '0', NULL),
(875, 965477, 'E', 'A', 'Mr.', 'CHANDRA', 'SHEKHAR', 'YADAV', 4, 46, 36, 516, 890, '7024653587', '', 'M', 'N', 'N', 273, '2016-02-01', NULL, '0', NULL),
(876, 965476, 'E', 'A', 'Mr.', 'TULSIRAM', '', 'GAJENDRA', 4, 46, 36, 516, 890, '0', '', 'M', 'N', 'N', 273, '2016-02-01', NULL, '0', NULL),
(877, 1008259, 'E', 'D', 'Mr.', 'GUMAN', '', 'SAHU', 4, 46, 33, 504, 898, '0', '', 'M', 'N', 'N', 274, '2016-05-02', NULL, '0', NULL),
(878, 870873, 'E', 'A', 'Mr.', 'DEBDULAL', '', 'SAMANTA', 4, 46, 30, 510, 903, '0', '', 'M', 'N', 'N', 276, '2015-11-20', NULL, '0', NULL),
(879, 1485501, 'E', 'D', 'Mr.', 'ATHVELLY', 'MADHAN', 'GOUD', 4, 46, 33, 504, 889, '8106712042', '', 'M', 'N', 'N', 275, '2018-11-01', NULL, '0', NULL),
(880, 1534917, 'E', 'A', 'Mr.', 'SURESH', 'KUMAR', 'CHAKRADHARI', 4, 46, 34, 504, 908, '0', '', 'M', 'N', 'N', 281, '2019-01-11', NULL, '0', NULL),
(881, 1606825, 'E', 'A', 'Mr.', 'PRASHANT', '', 'KUMAR', 4, 46, 29, 500, 895, '7050908081', '', 'M', 'N', 'N', 279, '2019-05-02', NULL, '0', NULL),
(882, 1603150, 'E', 'A', 'Mr.', 'VINAY', 'KUMAR', 'SINGH', 4, 46, 29, 500, 895, '0', '', 'M', 'N', 'N', 280, '2019-05-02', NULL, '0', NULL),
(883, 1163638, 'E', 'A', 'Mr.', 'JAGNA', 'BAHADUR', ' DHAMI', 4, 46, 34, 515, 897, '0', '', 'M', 'N', 'N', 278, '2017-03-01', NULL, '0', NULL),
(884, 1075189, 'E', 'A', 'Mr.', 'K', '', 'SATISH', 4, 46, 30, 511, 903, '0', '', 'M', 'N', 'N', 276, '2016-09-27', NULL, '0', NULL),
(885, 1190847, 'E', 'D', 'Mr.', 'BODDU', '', 'SRIKANTH', 4, 46, 33, 505, 889, '0', '', 'M', 'N', 'N', 275, '2017-05-02', NULL, '0', NULL),
(886, 1008257, 'E', 'A', 'Mr.', 'MANSHA', 'RAM', 'VERMA', 4, 46, 33, 505, 899, '0', '', 'M', 'N', 'N', 274, '2016-05-02', NULL, '0', NULL),
(887, 1126419, 'E', 'A', 'Mr.', 'VASUDEV', '', '.', 4, 46, 33, 504, 900, '0', '', 'M', 'N', 'N', 274, '2016-12-26', NULL, '0', NULL),
(888, 140, 'E', 'A', 'Mr.', 'RAJ', 'KUMAR', 'KUNDU', 4, 46, 33, 523, 0, '9302840331', 'rajkumar.kundu@vnrseeds.com', 'M', 'N', 'N', 274, '2008-02-18', NULL, '0', NULL),
(889, 148, 'E', 'A', 'Mr.', 'PRAKASH', 'KUMAR', 'KAPRI', 4, 46, 33, 530, 0, '9390340330', 'pk.kapri@vnrseeds.com', 'M', 'N', 'N', 275, '2008-04-10', NULL, '0', NULL);
INSERT INTO `master_employee` (`EmployeeID`, `EmpCode`, `EmpType`, `EmpStatus`, `Title`, `Fname`, `Sname`, `Lname`, `CompanyId`, `GradeId`, `DepartmentId`, `DesigId`, `RepEmployeeID`, `Contact`, `Email`, `Gender`, `Married`, `DR`, `Location`, `DOJ`, `DateOfSepration`, `CTC`, `LastUpdated`) VALUES
(890, 163, 'E', 'A', 'Mr.', 'ASHOK', 'KUMAR', 'PATEL', 4, 46, 36, 522, 0, '9300040330', 'ashok.patel@vnrseeds.com', 'M', 'N', 'N', 273, '2008-06-25', NULL, '0', NULL),
(891, 730, 'E', 'A', 'Dr.', 'KISLAY', 'KUMAR', 'SINHA', 4, 46, 36, 525, 0, '9279133837', 'kislay.sinha@vnrseeds.com', 'M', 'N', 'Y', 273, '2018-06-01', NULL, '0', NULL),
(892, 531, 'E', 'A', 'Mr.', 'AMIT ', '', 'KUMAR', 4, 46, 35, 524, 0, '9792692777', 'amit.kumar@vnrseeds.com', 'M', 'N', 'N', 273, '2015-05-02', NULL, '0', NULL),
(893, 45, 'E', 'A', 'Mr.', 'HARENDRA', '', 'KUMAR', 4, 46, 31, 528, 0, '9329040330', 'gautam.sharma@vnrseeds.com', 'M', 'N', 'N', 273, '2007-02-01', NULL, '0', NULL),
(894, 877, 'E', 'A', 'Mr.', 'HEMCHAND', '', 'K', 4, 46, 31, 531, 0, '9840434334', 'hemchand.k@vnrseeds.com', 'M', 'N', 'N', 273, '2019-07-12', NULL, '0', NULL),
(895, 85, 'E', 'A', 'Mr.', 'NANDKISHORE', '', 'SHARMA', 4, 46, 32, 527, 0, '9302847007', 'nandkishore.sharma@vnrseeds.com', 'M', 'N', 'N', 273, '2007-08-06', NULL, '0', NULL),
(896, 244, 'E', 'A', 'Mr.', 'MANISH', '', 'KARKUN', 4, 46, 30, 526, 0, '9685436177', 'manish.karkun@vnrseeds.com', 'M', 'N', 'N', 273, '2009-06-02', NULL, '0', NULL),
(897, 362, 'E', 'A', 'Mr.', 'HARI  ', '', 'PRASAD', 4, 46, 39, 529, 0, '9981995392', 'hariprasad.verma@vnrseeds.in', 'M', 'N', 'N', 274, '2011-11-21', NULL, '0', NULL),
(898, 402, 'E', 'A', 'Mr.', 'JAGDEEP', '', 'KUMAR', 4, 46, 33, 530, 0, '9302740330', 'jagdeep.kumar@vnrseeds.in', 'M', 'N', 'N', 274, '2012-12-03', NULL, '0', NULL),
(899, 375, 'E', 'A', 'Mr.', 'RAJESH', 'PAL', 'SINGH', 4, 46, 33, 534, 0, '9303640335', 'rajesh.pal@vnrseeds.in', 'M', 'N', 'N', 274, '2012-05-05', NULL, '0', NULL),
(900, 372, 'E', 'A', 'Mr.', 'SAIYYAD', 'SUHAIL', 'HUSSAIN', 4, 46, 33, 535, 0, '9589281500', 'saiyyad.suhail@vnrseeds.in', 'M', 'N', 'N', 274, '2012-04-16', NULL, '0', NULL),
(901, 48, 'E', 'A', 'Mr.', 'ISHWARI', 'PRASAD', 'YADAV', 4, 46, 33, 536, 0, '8839091603', 'ishwari.yadav@vnrseeds.com', 'M', 'N', 'N', 274, '2007-02-01', NULL, '0', NULL),
(902, 17, 'E', 'A', 'Mr.', 'KRISHAN ', 'CHANDRA', 'UPADHYAY', 4, 46, 36, 537, 0, '8008261509', 'kc@vnrseeds.com', 'M', 'N', 'N', 276, '2005-12-03', NULL, '0', NULL),
(903, 216, 'E', 'A', 'Mr.', 'PARAG', '', 'AGARWAL', 4, 46, 36, 538, 0, '9573678382', 'parag.agarwal@vnrseeds.com', 'M', 'N', 'N', 276, '2009-01-12', NULL, '0', NULL),
(904, 151, 'E', 'A', 'Mr.', 'ROOPAM', '', 'JOHRI', 4, 46, 38, 539, 0, '9302730007', 'roopam.johri@vnrseeds.com', 'M', 'N', 'N', 273, '2008-05-08', NULL, '0', NULL),
(905, 291, 'E', 'A', 'Mr.', 'PARUL', '', 'PARMAR', 4, 46, 38, 540, 0, '9300125137', 'parul.parmar@vnrseeds.com', 'M', 'N', 'N', 273, '2010-04-30', NULL, '0', NULL),
(906, 139, 'E', 'A', 'Mr.', 'ATUL', '', 'SAH', 4, 46, 35, 532, 0, '9630040330', 'atul.sah@vnrseeds.com', 'M', 'N', 'N', 273, '2008-02-09', NULL, '0', NULL),
(907, 590, 'E', 'A', 'Mr.', 'ARVIND', 'KUMAR', 'AGRAWAL', 4, 46, 37, 533, 0, '9329570007', 'fd@vnrseeds.com', 'M', 'N', 'N', 273, '2016-04-01', NULL, '0', NULL),
(908, 415, 'E', 'A', 'Mr.', 'GYAN', 'PRAKASH', 'PAL', 4, 46, 39, 542, 0, '9179042140', 'gp.pal@vnrseeds.in', 'M', 'N', 'N', 281, '2020-01-11', NULL, '0', NULL),
(909, 245, 'E', 'A', 'Mr.', 'ASHISH', '', 'BAJPAI', 4, 46, 30, 541, 0, '9301260007', 'gm.finance@vnrseeds.com', 'M', 'N', 'N', 273, '2009-06-02', NULL, '0', NULL),
(910, 14, 'E', 'A', 'Mr.', 'S', '', 'RUDRAPRAKASH', 4, 46, 34, 543, 0, '9380040330', 'rudy@vnrseeds.com', 'M', 'N', 'N', 283, '2005-07-01', NULL, '0', NULL),
(911, 142, 'E', 'A', 'Mr.', 'D. ROHINI', '', 'NARASAIYA', 4, 46, 29, 544, 0, '9425018823', 'd.rohini@vnrseeds.com', 'M', 'N', 'N', 273, '2008-03-20', NULL, '0', NULL),
(912, 970, 'E', 'A', 'Mr.', 'MUNESH ', 'KUMAR', 'TEVTIA', 1, 70, 6, 66, 531, '9588883057', 'munesh.tevtia@vnrseeds.com', 'M', 'Y', 'N', 74, '2020-01-27', NULL, '1673463', NULL),
(913, 971, 'E', 'A', 'Mr.', 'PRADEEP ', 'SUBHASHRAO', 'PATIL', 1, 70, 6, 66, 531, '9518530839', 'pradeep.patil@vnrseeds.com', 'M', 'Y', 'N', 46, '2020-01-27', NULL, '1881513', NULL),
(914, 972, 'E', 'D', 'Mr.', 'NAVEEN', '', 'MATTOO', 1, 70, 6, 66, 531, '9988888291', 'naveen.mattoo@vnrseeds.com', 'M', 'Y', 'N', 132, '2020-01-27', '2020-03-14', '1675002', NULL),
(915, 973, 'E', 'A', 'Mr.', 'ASHISH', '', 'NAUTIYAL', 1, 69, 6, 67, 140, '8676994488', 'ashish.nautiyal@vnrseeds.com', 'M', 'Y', 'N', 10, '2020-01-27', NULL, '1680667', NULL),
(916, 974, 'E', 'A', 'Mr.', 'DIBAKAR', '', 'DAS', 1, 69, 6, 67, 140, '9435733436', 'dibakar.das@vnrseeds.com', 'M', 'Y', 'N', 197, '2020-01-27', NULL, '1891772', NULL),
(917, 40, 'E', 'A', 'Ms.', 'ANAMIKAA', '', 'MAJUMDAR', 3, 31, 26, 163, 254, '8128959994', 'customer.service@vnrnursery.in', 'F', 'N', 'N', 102, '2020-01-02', NULL, '270251', NULL),
(918, 975, 'E', 'D', 'Mr.', 'DIPANKAR', '', 'DAS', 1, 63, 24, 300, 326, '9407633794', 'dipankardas.vspl@gmail.com', 'M', 'N', 'N', 155, '2020-02-03', NULL, '303803', NULL),
(919, 976, 'E', 'A', 'Mr.', 'BOMMINENI ', 'VIJAY CHANDER', 'REDDY', 1, 65, 6, 255, 220, '9573146648', 'vijaychander.vspl@gmail.com', 'M', 'N', 'N', 129, '2020-02-04', NULL, '386999', NULL),
(920, 977, 'E', 'D', 'Mr.', 'VINOD ', 'KUMAR', 'SHARMA', 1, 62, 2, 10, 209, '8569869125', '', 'M', 'Y', 'N', 12, '2020-02-04', '2021-01-23', '276854', NULL),
(921, 978, 'E', 'A', 'Mr.', 'GUMAN', '', 'SAHU', 1, 64, 5, 611, 246, '9926253284', '', 'M', 'Y', 'N', 14, '2020-02-10', NULL, '300863', NULL),
(922, 979, 'E', 'A', 'Mr.', 'KUMAR', '', 'YADAV', 1, 64, 5, 612, 20, '7828370945', '', 'M', 'Y', 'N', 14, '2020-02-10', NULL, '252297', NULL),
(923, 980, 'E', 'A', 'Mr.', 'PRAMOD', 'KUMAR', 'SAHU', 1, 65, 5, 461, 246, '9074926747', 'pramodsahu.vspl@gmail.com', 'M', 'Y', 'N', 14, '2020-02-10', NULL, '357827', NULL),
(924, 981, 'E', 'A', 'Mr.', 'MANOJ', 'KUMAR', 'SHARDA', 1, 70, 6, 66, 34, '9413921312', 'manoj.sharda@vnrseeds.com', 'M', 'Y', 'N', 21, '2020-02-12', NULL, '1830841', NULL),
(925, 982, 'E', 'A', 'Mr.', 'GUGULOTHU', '', 'SRINIVAS', 1, 65, 6, 255, 220, '9390426393', 'srinivasgugulothu.vspl@gmail.com', 'M', 'Y', 'N', 68, '2020-02-15', NULL, '420282', NULL),
(926, 983, 'E', 'A', 'Mr.', 'GAURAV', ' ', 'DIWAKAR', 1, 66, 6, 68, 584, '9829411418', 'gauravdiwakar.vspl@gmail.com', 'M', 'N', 'N', 286, '2020-02-17', NULL, '668167', NULL),
(927, 984, 'E', 'A', 'Mr.', 'KETAN', 'BALASAHEB', 'RAUNDAL', 1, 68, 3, 604, 719, '9307966767', 'ketanraundal.vspl@gmail.com', 'M', 'Y', 'N', 1, '2020-02-20', NULL, '1090819', NULL),
(928, 985, 'E', 'A', 'Mr.', 'KAMLESH ', '', 'PATEL', 1, 65, 6, 255, 14, '9893585252', 'kamleshpatel.vspl@gmail.com', 'M', 'Y', 'N', 290, '2020-02-20', NULL, '442470', NULL),
(929, 986, 'E', 'A', 'Mr.', 'AJAY', '', 'PACHAURI', 1, 63, 6, 254, 14, '9098655183', 'ajaypachauri.vspl@gmail.com', 'M', 'N', 'N', 172, '2020-02-20', NULL, '351395', NULL),
(930, 987, 'E', 'A', 'Mr.', 'SACHIN ', '', 'KUMAR', 1, 64, 6, 257, 584, '8756506313', 'sachinkumar.vspl@gmail.com', 'M', 'Y', 'N', 194, '2020-02-25', NULL, '412305', NULL),
(931, 988, 'E', 'A', 'Dr.', 'MOHIT', '', 'CHAUDHARY', 1, 68, 2, 5, 89, '9416210117', 'mohit.chaudhary@vnrseeds.com', 'M', 'N', 'Y', 63, '2020-02-25', NULL, '784274', NULL),
(932, 989, 'E', 'A', 'Mr.', 'RAMESH', '', 'CHAND', 1, 65, 6, 255, 912, '9799730840', 'rameshchand.vspl@gmail.com', 'M', 'Y', 'N', 134, '2020-02-26', NULL, '473273', NULL),
(933, 990, 'E', 'A', 'Mr.', 'YATENDRA', '', 'KHIRWAR', 1, 65, 6, 255, 912, '7983237448', 'yatendrakhirwar.vspl@gmail.com', 'M', 'Y', 'N', 74, '2020-02-29', NULL, '412256', NULL),
(934, 991, 'E', 'D', 'Mr.', 'BASAVANAGOUDA', '', 'PATIL', 1, 67, 2, 5, 89, '8904898992', 'basavanagoudap.vspl@gmail.com', 'M', 'N', 'N', 7, '2020-03-02', '2021-04-06', '582704', NULL),
(935, 992, 'E', 'A', 'Mr.', 'VINOD', 'BASAVANTRAYA', 'BIRADAR', 1, 64, 6, 257, 718, '8867457117', 'vinodbiradar.vspl@gmail.com', 'M', 'N', 'N', 220, '2020-03-02', NULL, '459271', NULL),
(936, 993, 'E', 'A', 'Mr.', 'DEEPAK', '', 'SHARMA', 1, 64, 6, 257, 261, '9334703803', 'deepaksharma.vspl@gmail.com', 'M', 'Y', 'N', 108, '2020-03-12', NULL, '340643', NULL),
(937, 994, 'E', 'A', 'Mr.', 'ALLETI', '', 'SANDEEP', 1, 64, 4, 306, 145, '8179152212', 'alletisandeep.vspl@gmail.com', 'M', 'N', 'N', 129, '2020-03-12', NULL, '581170', NULL),
(938, 995, 'E', 'A', 'Mr.', 'AJEY', 'KUMAR', 'MISHRA', 1, 64, 6, 257, 584, '9669718659', 'ajeykmishra.vspl@gmail.com', 'M', 'N', 'N', 66, '2020-03-16', NULL, '408108', NULL),
(939, 996, 'E', 'A', 'Mr.', 'KAMAL', 'KUMAR', 'SINGH', 1, 63, 6, 254, 915, '9161702328', 'kamalksinghvspl@gmail.com', 'M', 'Y', 'N', 232, '2020-03-16', NULL, '336395', NULL),
(940, 997, 'E', 'D', 'Mr.', 'ANAND', 'KUMAR', 'SINGH', 1, 63, 6, 286, 4, '9628552900', 'anandku.singh.vspl@gmail.com', 'M', 'N', 'N', 67, '2020-03-16', '2021-02-25', '281129', NULL),
(941, 998, 'E', 'A', 'Mr.', 'ANKIT', 'KUMAR', 'SINGH', 1, 64, 6, 257, 915, '9450548482', 'ankitksingh.vspl@gmail.com', 'M', 'N', 'N', 223, '2020-03-16', NULL, '398039', NULL),
(942, 999, 'E', 'A', 'Mr.', 'JAKKIREDDY', 'RAJASHEKAR', 'REDDY', 1, 64, 6, 257, 597, '9665325632', 'jrajashekarreddy.vspl@gmail.com', 'M', 'N', 'N', 294, '2020-03-19', NULL, '295595', NULL),
(943, 1000, 'E', 'D', 'Mr.', 'DEVESH', '', 'KUMAR', 1, 63, 6, 254, 11, '9149227079', 'deveshkumar.vspl@gmail.com', 'M', 'N', 'N', 363, '2020-03-20', '2021-06-24', '319799', NULL),
(944, 1001, 'E', 'A', 'Mr.', 'ANAND', '', 'KUMAR', 1, 66, 6, 68, 946, '9451036498', 'anandmishra.vspl@gmail.com', 'M', 'Y', 'N', 35, '2020-04-02', NULL, '685471', NULL),
(945, 1002, 'E', 'A', 'Mr.', 'SANDEEP', 'KUMAR', 'SHRIVAS', 1, 66, 6, 68, 252, '8103195950', 'sandeepshrivas.vspl@gmail.com', 'M', 'N', 'N', 66, '2020-04-06', NULL, '586766', NULL),
(946, 1003, 'E', 'A', 'Mr.', 'RAVEESH', '', 'AGNIHOTRI', 1, 70, 6, 66, 399, '9839324142', 'raveesh.agnihotri@vnrseeds.com', 'M', 'Y', 'N', 12, '2020-04-09', NULL, '1605819', NULL),
(947, 1004, 'E', 'A', 'Mr.', 'VISHWANATH', 'SANGANAGOUDA', 'PATIL', 1, 71, 2, 2, 89, '9880877898', 'vishwanath.patil@vnrseeds.com', 'M', 'Y', 'N', 204, '2020-04-23', NULL, '2251972', NULL),
(948, 101, 'E', 'A', 'Mr.', 'SURENDRA', '', 'KUMAR', 4, 46, 34, 553, 888, '8959590910', 'surendra.kumar@vnrseeds.com', 'M', 'N', 'N', 278, '2007-11-01', NULL, '0', NULL),
(949, 896, 'E', 'A', 'Mr.', 'SUJEET', 'KUMAR', 'SINGH', 4, 46, 34, 554, 948, '9009129070', 'sujeet.singh@vnrseeds.com', 'M', 'N', 'N', 273, '2019-09-10', NULL, '0', NULL),
(950, 897, 'E', 'A', 'Mr.', 'RAJENDRA', '', 'PRASAD', 4, 46, 34, 555, 949, '6260186370', 'rajendra.prasad@vnrseeds.com', 'M', 'N', 'N', 273, '2019-09-10', NULL, '0', NULL),
(951, 961, 'E', 'A', 'Mr.', 'RAGHUBANSH', 'MANI', 'SINGH', 4, 46, 34, 556, 950, '8120985120', 'raghubanshmani.singh@vnrseeds.com', 'M', 'N', 'N', 281, '2019-12-16', NULL, '0', NULL),
(952, 501, 'E', 'A', 'Mr.', 'VINOD', '', 'KUMAR', 4, 46, 34, 554, 948, '9000350001', 'vinod.kumar@vnrseeds.com', 'M', 'N', 'N', 278, '2014-10-29', NULL, '0', NULL),
(953, 166, 'E', 'A', 'Mr.', 'CHANDRAKANT', '', 'SINGH', 4, 46, 34, 557, 951, '9993926951', 'Chandrakantsinghrajput539@gmail.com', 'M', 'N', 'N', 281, '2008-07-01', NULL, '0', NULL),
(954, 1746206, 'E', 'A', 'Mr.', 'DURGESH', 'SINGH', 'CHAUHAN', 4, 46, 34, 558, 953, '0', '', 'M', 'N', 'N', 281, '2019-11-01', NULL, '0', NULL),
(955, 297, 'E', 'A', 'Mr.', 'ASHUTOSH', '', 'VERMA', 4, 46, 34, 556, 952, '9494857755', 'ashutosh.verma@vnrseeds.com', 'M', 'N', 'N', 278, '2010-07-02', NULL, '0', NULL),
(956, 1746209, 'E', 'A', 'Mr.', 'GIRISH', '', 'CHANDRAKAR', 4, 46, 34, 558, 953, '0', '', 'M', 'N', 'N', 307, '2019-11-01', NULL, '0', NULL),
(957, 792, 'E', 'A', 'Mr.', 'BASANT', '', 'SINGH', 4, 79, 34, 558, 0, '7978159002', 'basantsingh.vspl@gmail.com', 'M', 'N', 'N', 309, '2018-10-01', NULL, '0', NULL),
(958, 1746208, 'E', 'A', 'Mr.', 'TUKESHWAR', '', 'CHANDRAKAR', 4, 46, 34, 558, 960, '0', '', 'M', 'N', 'N', 308, '2019-11-01', NULL, '0', NULL),
(959, 911, 'E', 'A', 'Mr.', 'DURGESH', 'PRATAP', 'SINGH', 4, 46, 34, 556, 949, '8120045902', 'durgeshprataps.vspl@gmail.com', 'M', 'N', 'N', 310, '2019-09-17', NULL, '0', NULL),
(960, 923, 'E', 'A', 'Mr.', 'DIGOO', 'PRASAD', 'SINHA', 4, 46, 34, 560, 0, '0', '', 'M', 'N', 'N', 281, '2019-10-01', NULL, '0', NULL),
(961, 966, 'E', 'A', 'Mr.', 'AJAY ', 'KUMAR', 'SINGH', 4, 46, 34, 556, 950, '9439511339', 'ajaykumar.singh@vnrseeds.com', 'M', 'N', 'N', 311, '2020-01-02', NULL, '0', NULL),
(962, 939, 'E', 'A', 'Mr.', 'VEERENDRA', 'PAL', 'SINGH', 4, 46, 34, 556, 952, '9701709241', 'veerendrapsingh.vspl@gmail.com', 'M', 'N', 'N', 277, '2019-10-11', NULL, '0', NULL),
(963, 1746203, 'E', 'A', 'Mr.', 'MANHARAN', '', 'LAL', 4, 46, 34, 562, 953, '0', '', 'M', 'N', 'N', 312, '2019-10-01', NULL, '0', NULL),
(964, 960, 'E', 'A', 'Mr.', 'GURU PRASAD', '', 'BARAL', 4, 46, 34, 561, 961, '8018743140', 'guruprasadbaral.vspl@gmail.com', 'M', 'N', 'N', 313, '2019-12-10', NULL, '0', NULL),
(965, 1746207, 'E', 'A', 'Mr.', 'ARJUN', 'SING', 'SIDAR', 4, 46, 34, 562, 0, '0', '', 'M', 'N', 'N', 314, '2019-11-01', NULL, '0', NULL),
(966, 955, 'E', 'A', 'Mr.', 'JITENDRA', '', 'JAISWAL', 4, 46, 34, 557, 951, '9893219117', 'jitendrajaiswal.vspl@gmail.com', 'M', 'N', 'N', 281, '2019-11-13', NULL, '0', NULL),
(967, 1746133, 'E', 'A', 'Mr.', 'KANHA', '', 'SAHU', 4, 46, 34, 558, 953, '0', '', 'M', 'N', 'N', 312, '2019-11-01', NULL, '0', NULL),
(968, 1746131, 'E', 'A', 'Mr.', 'GHANSHYAM', '', 'SAHU', 4, 46, 34, 558, 953, '0', '', 'M', 'N', 'N', 315, '2019-11-01', NULL, '0', NULL),
(969, 1746137, 'E', 'A', 'Mr.', 'ANGAD', '', 'MOURYA', 4, 46, 34, 558, 953, '0', '', 'M', 'N', 'N', 315, '2019-11-01', NULL, '0', NULL),
(970, 1746132, 'E', 'A', 'Mr.', 'HARIHARA', '', 'BHOI', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-11-01', NULL, '0', NULL),
(971, 1748550, 'E', 'A', 'Mr.', 'YOGENDRA ', ' KUMAR', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 316, '2019-11-01', NULL, '0', NULL),
(972, 1746136, 'E', 'A', 'Mr.', 'PABITRA', '', 'MAHAPATRA', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-11-01', NULL, '0', NULL),
(973, 1746135, 'E', 'A', 'Mr.', 'RAJESH', 'KUMAR', 'PITHOI', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-11-01', NULL, '0', NULL),
(974, 1752095, 'E', 'A', 'Mr.', 'DASARI', 'SANTHOSH', 'KUMAR', 4, 46, 34, 560, 952, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(975, 1748549, 'E', 'A', 'Mr.', 'LAVAN', '', ' KUMAR', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 317, '2019-11-01', NULL, '0', NULL),
(976, 1752088, 'E', 'A', 'Mr.', 'MD', '', 'GHOUSE', 4, 46, 34, 560, 978, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(977, 1761832, 'E', 'A', 'Mr.', 'SADA', '', ' SUDHARSHAN', 4, 46, 34, 560, 962, '0', '', 'M', 'N', 'N', 278, '2019-11-07', NULL, '0', NULL),
(978, 954, 'E', 'A', 'Mr.', 'SHAIK ABDUL', 'RAHMAN', 'ASAD', 4, 46, 34, 561, 980, '9949928817', '', 'M', 'N', 'N', 278, '2019-11-11', NULL, '0', NULL),
(979, 1761835, 'E', 'A', 'Mr.', 'SURESH', '', '.', 4, 46, 34, 560, 955, '0', '', 'M', 'N', 'N', 318, '2019-11-15', NULL, '0', NULL),
(980, 938, 'E', 'A', 'Mr.', 'RAJEEV', '', 'KUMAR', 4, 46, 34, 563, 952, '7702579871', 'rajeevkumar.vspl@gmail.com', 'M', 'N', 'N', 278, '2019-10-11', NULL, '0', NULL),
(981, 1761834, 'E', 'A', 'Mr.', 'BOYA ', '', 'RAMESH', 4, 46, 34, 560, 955, '0', '', 'M', 'N', 'N', 318, '2019-11-19', NULL, '0', NULL),
(982, 1752084, 'E', 'A', 'Mr.', 'CHITYALA', 'SANJEEV', 'KUMAR', 4, 46, 34, 560, 962, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(983, 1761833, 'E', 'A', 'Mr.', 'RAMESH', '', ' KONDIKOPPULA', 4, 46, 34, 564, 952, '0', '', 'M', 'N', 'N', 277, '2019-12-05', NULL, '0', NULL),
(984, 1752086, 'E', 'A', 'Mr.', 'VEMULAWADA', 'VISHNU', 'PRASAD', 4, 46, 34, 560, 952, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(985, 1752085, 'E', 'A', 'Mr.', 'MATHANGI', '', 'MAHENDAR', 4, 46, 34, 560, 962, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(986, 1769515, 'E', 'A', 'Mr.', 'VISHAL ', '', 'SHARMA', 4, 46, 34, 515, 957, '0', '', 'M', 'N', 'N', 309, '2019-12-01', NULL, '0', NULL),
(987, 1752098, 'E', 'A', 'Mr.', 'SUNIL', '', 'JAYANT', 4, 46, 34, 565, 962, '0', '', 'M', 'N', 'N', 278, '2019-11-04', NULL, '0', NULL),
(988, 1752101, 'E', 'A', 'Mr.', 'AAKASH', '', 'PATLYA', 4, 46, 34, 565, 955, '0', '', 'M', 'N', 'N', 318, '2019-11-04', NULL, '0', NULL),
(989, 112, 'E', 'A', 'Mr.', 'LOCHAN', 'KUMAR', 'GOHIL', 4, 46, 34, 557, 0, '9981995399', 'lochan.gohil@vnrseeds.in', 'M', 'N', 'N', 319, '2008-01-01', NULL, '0', NULL),
(990, 1752091, 'E', 'A', 'Mr.', 'DUSSA', '', 'SRINIVAS', 4, 46, 34, 560, 992, '0', '', 'M', 'N', 'N', 277, '2019-11-01', NULL, '0', NULL),
(991, 1769516, 'E', 'A', 'Mr.', 'S K ', 'RAMOJI ', 'ALI', 4, 46, 34, 515, 957, '0', '', 'M', 'N', 'N', 321, '2019-12-01', NULL, '0', NULL),
(992, 498, 'E', 'A', 'Mr.', 'RAJESH', 'KUMAR', 'SINGH', 4, 46, 34, 555, 948, '0', '', 'M', 'N', 'N', 320, '2014-10-01', NULL, '0', NULL),
(993, 909, 'E', 'A', 'Mr.', 'DURGESH', '.', '.', 4, 46, 34, 561, 0, '7978698718', 'durgesh.vspl@gmail.com', 'M', 'N', 'N', 323, '2019-09-17', NULL, '0', NULL),
(994, 1752087, 'E', 'A', 'Mr.', 'ANIL', '', 'KUMAR', 4, 46, 34, 560, 980, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(995, 1777351, 'E', 'A', 'Mr.', 'NARSINGH ', '', 'VATTI', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 322, '2019-12-01', NULL, '0', NULL),
(996, 1752100, 'E', 'A', 'Mr.', 'GANDLA', '', 'PANDU', 4, 46, 34, 560, 992, '0', '', 'M', 'N', 'N', 278, '2019-11-09', NULL, '0', NULL),
(997, 1752096, 'E', 'A', 'Mr.', 'S', 'PREM', 'KUMAR', 4, 46, 34, 560, 980, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(998, 1738934, 'E', 'A', 'Mr.', 'ROSHAN', 'LAL', 'SAHU', 4, 46, 34, 562, 959, '0', '', 'M', 'N', 'N', 324, '2019-10-01', NULL, '0', NULL),
(999, 1752093, 'E', 'A', 'Mr.', 'THALLAPALLI', 'SRINIVAS', 'GOUD', 4, 46, 34, 560, 962, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(1000, 1752083, 'E', 'A', 'Mr.', 'ETTAPU', '', 'SAMPATH', 4, 46, 34, 560, 1001, '0', '', 'M', 'N', 'N', 278, '2019-11-01', NULL, '0', NULL),
(1001, 260, 'E', 'A', 'Mr.', 'POTHRAJU', '', 'VITTAL', 4, 46, 34, 561, 962, '9866340661', 'pothvittal@gmail.com', 'M', 'N', 'N', 278, '2009-10-12', NULL, '0', NULL),
(1002, 1773883, 'E', 'A', 'Mr.', 'PASUPULA ', '', 'NARASIMHULU', 4, 46, 34, 515, 955, '0', '', 'M', 'N', 'N', 318, '2019-12-12', NULL, '0', NULL),
(1003, 1752094, 'E', 'A', 'Mr.', 'ASADU', '', 'LAXMAN', 4, 46, 34, 560, 955, '0', '', 'M', 'N', 'N', 325, '2019-11-01', NULL, '0', NULL),
(1004, 1738942, 'E', 'A', 'Mr.', 'DOMENDRA', 'KUMAR', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 317, '2019-10-01', NULL, '0', NULL),
(1005, 1773884, 'E', 'A', 'Mr.', 'MALLELA ', '', 'MALLIKARJUNA', 4, 46, 34, 515, 955, '0', '', 'M', 'N', 'N', 318, '2019-12-12', NULL, '0', NULL),
(1006, 452, 'E', 'A', 'Mr.', 'SANJAY', '', 'KUMAR', 4, 46, 34, 563, 948, '9640788800', 'sanjay.vnr@gmail.com', 'M', 'N', 'N', 277, '2014-01-30', NULL, '0', NULL),
(1007, 1748551, 'E', 'A', 'Mr.', 'PUKLAL', '', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 326, '2019-11-01', NULL, '0', NULL),
(1008, 1738929, 'E', 'A', 'Mr.', 'MANOJ', 'KUMAR', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 324, '2019-10-01', NULL, '0', NULL),
(1009, 1738964, 'E', 'A', 'Mr.', 'MOHAN', 'LAL', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 328, '2019-10-01', NULL, '0', NULL),
(1010, 1738943, 'E', 'A', 'Mr.', 'SUKIRTI ', '', 'NAYAK', 4, 46, 34, 560, 957, '0', '', 'M', 'N', 'N', 327, '2019-10-15', NULL, '0', NULL),
(1011, 1738973, 'E', 'A', 'Mr.', 'RAMSUDHARE', '', '', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 329, '2019-10-01', NULL, '0', NULL),
(1012, 1738967, 'E', 'A', 'Mr.', 'JAGANNATH', '', 'SEN', 4, 46, 34, 560, 957, '0', '', 'M', 'N', 'N', 309, '2019-10-15', NULL, '0', NULL),
(1013, 1738968, 'E', 'A', 'Mr.', 'ANJAN', 'KUMAR', 'BEHERA', 4, 46, 34, 560, 957, '0', '', 'M', 'N', 'N', 309, '2019-10-15', NULL, '0', NULL),
(1014, 1738969, 'E', 'A', 'Mr.', 'NAVNEET', '', 'SHARMA', 4, 46, 34, 565, 952, '0', '', 'M', 'N', 'N', 278, '2019-10-21', NULL, '0', NULL),
(1015, 1738958, 'E', 'A', 'Mr.', 'KRISHNANAND', '', '.', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 330, '2019-10-01', NULL, '0', NULL),
(1016, 1738927, 'E', 'A', 'Mr.', 'RAM ', 'PRATAP', 'GOND', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 324, '2019-10-01', NULL, '0', NULL),
(1017, 1738925, 'E', 'A', 'Mr.', 'AMARCHAND', '.', ' VERMA', 4, 46, 34, 560, 959, '0', '', 'M', 'N', 'N', 310, '2019-10-01', NULL, '0', NULL),
(1018, 1738951, 'E', 'A', 'Mr.', 'GANESHWAR', 'RAM ', 'NETAM', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 331, '2019-10-01', NULL, '0', NULL),
(1019, 1738970, 'E', 'A', 'Mr.', 'UGRASEN ', '', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 330, '2019-10-01', NULL, '0', NULL),
(1020, 1738962, 'E', 'A', 'Mr.', 'SATYANARAYAN ', '', 'DHRUV', 4, 46, 34, 508, 959, '0', '', 'M', 'N', 'N', 322, '2019-10-01', NULL, '0', NULL),
(1021, 1738949, 'E', 'A', 'Mr.', 'SEVENDRA', '', 'KUMAR', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 333, '2019-10-07', NULL, '0', NULL),
(1022, 1738945, 'E', 'A', 'Mr.', 'TRINATH', '', 'NAYAK', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1023, 1738930, 'E', 'A', 'Mr.', 'KHEERBHAN', '', 'MARKAM', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 334, '2019-10-01', NULL, '0', NULL),
(1024, 1738935, 'E', 'A', 'Mr.', 'SARVESH', 'KUMAR', 'SINGH', 4, 46, 34, 562, 959, '0', '', 'M', 'N', 'N', 324, '2019-10-01', NULL, '0', NULL),
(1025, 1738975, 'E', 'A', 'Mr.', 'SHIT ', 'KUMAR', 'DESHLAHARA', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 335, '2019-10-01', NULL, '0', NULL),
(1026, 1738928, 'E', 'A', 'Mr.', 'GANGADHAR', '', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 324, '2019-10-01', NULL, '0', NULL),
(1027, 1738957, 'E', 'A', 'Mr.', 'NOGENDRA', '', 'SAHU', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 336, '2019-10-01', NULL, '0', NULL),
(1028, 1738944, 'E', 'A', 'Mr.', 'BRUHATA', 'BHANU', 'BHATTA', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1029, 1738933, 'E', 'A', 'Mr.', 'SACHIKANT', '', 'BEHERA', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1030, 1738959, 'E', 'A', 'Mr.', 'KALPE ', '', 'THAKUR', 4, 46, 34, 560, 993, '0', '', 'M', 'N', 'N', 337, '2019-10-01', NULL, '0', NULL),
(1031, 1738941, 'E', 'A', 'Mr.', 'SANTOSHA', 'KUMAR', 'SWAIN', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1032, 1736329, 'E', 'A', 'Mr.', 'DEBRAJ', '', 'PATEL', 4, 46, 34, 515, 993, '0', '', 'M', 'N', 'N', 337, '2019-10-01', NULL, '0', NULL),
(1033, 1738932, 'E', 'A', 'Mr.', 'SUSHNATA ', '', 'RANA', 4, 46, 34, 515, 993, '0', '', 'M', 'N', 'N', 337, '2019-10-01', NULL, '0', NULL),
(1034, 1738954, 'E', 'A', 'Mr.', 'RAMU ', '', 'KUMBHAR', 4, 46, 34, 562, 989, '0', '', 'M', 'N', 'N', 319, '2019-10-01', NULL, '0', NULL),
(1035, 1738955, 'E', 'A', 'Mr.', 'SUNADHAR', '', 'HATI', 4, 46, 34, 560, 0, '0', '', 'M', 'N', 'N', 319, '2019-10-01', NULL, '0', NULL),
(1036, 1738961, 'E', 'A', 'Mr.', 'SUNIL', '', 'BHOLA', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1037, 1738972, 'E', 'A', 'Mr.', 'RAMESH', '', 'BARIK', 4, 46, 34, 515, 957, '0', '', 'M', 'N', 'N', 309, '2019-10-01', NULL, '0', NULL),
(1038, 1738946, 'E', 'A', 'Mr.', 'PRAKASH', 'CHANDRA', 'JENA', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1039, 1738960, 'E', 'A', 'Mr.', 'MILAN', 'KUMAR', 'KANDI', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1040, 1738947, 'E', 'A', 'Mr.', 'PRANAB', 'KUMAR ', 'PARIDA', 4, 46, 34, 515, 957, '0', '', 'M', 'N', 'N', 309, '2019-10-01', NULL, '0', NULL),
(1041, 1738953, 'E', 'A', 'Mr.', 'DASARTHI', '', 'BHOI', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1042, 1738952, 'E', 'A', 'Mr.', 'MANAS', 'CHANDRA', 'MALLICK', 4, 46, 34, 560, 961, '0', '', 'M', 'N', 'N', 313, '2019-10-01', NULL, '0', NULL),
(1043, 1738956, 'E', 'A', 'Mr.', 'BHUPENDRA', '', 'KUMAR ', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 339, '2019-10-01', NULL, '0', NULL),
(1044, 1738931, 'E', 'A', 'Mr.', 'BHOODTHULA', '', 'JALAPATHI', 4, 46, 34, 560, 980, '0', '', 'M', 'N', 'N', 277, '2019-10-01', NULL, '0', NULL),
(1045, 1738926, 'E', 'A', 'Mr.', 'LEKHU', '', 'RAM', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 281, '2019-10-01', NULL, '0', NULL),
(1046, 1738965, 'E', 'A', 'Mr.', 'MUDDAM', '', 'THIRUMALESH', 4, 46, 34, 560, 962, '0', '', 'M', 'N', 'N', 277, '2019-10-14', NULL, '0', NULL),
(1047, 1738971, 'E', 'A', 'Mr.', 'BANDARI', '', 'SRINIVAS', 4, 46, 34, 560, 1006, '0', '', 'M', 'N', 'N', 277, '2019-10-01', NULL, '0', NULL),
(1048, 1738936, 'E', 'A', 'Mr.', 'NARAYAN', '', 'NIRMALKAR', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 342, '2019-10-01', NULL, '0', NULL),
(1049, 1738974, 'E', 'A', 'Mr.', 'JILLALA ', '', 'NARESH', 4, 46, 34, 560, 952, '0', '', 'M', 'N', 'N', 277, '2019-10-10', NULL, '0', NULL),
(1050, 1738940, 'E', 'A', 'Mr.', 'DASARAPU', '', 'RAJENDER', 4, 46, 34, 560, 980, '0', '', 'M', 'N', 'N', 277, '2019-10-03', NULL, '0', NULL),
(1051, 1738938, 'E', 'A', 'Mr.', 'SHIKHAR', '', 'VERMA', 4, 46, 34, 560, 1006, '0', '', 'M', 'N', 'N', 277, '2019-10-01', NULL, '0', NULL),
(1052, 1738939, 'E', 'A', 'Mr.', 'PRAKHAR', '', 'VERMA', 4, 46, 34, 560, 1006, '0', '', 'M', 'N', 'N', 277, '2019-10-01', NULL, '0', NULL),
(1053, 1738948, 'E', 'A', 'Mr.', 'KULDEEP', '', 'SINGH', 4, 46, 34, 560, 955, '0', '', 'M', 'N', 'N', 277, '2019-10-15', NULL, '0', NULL),
(1054, 1738791, 'E', 'A', 'Mr.', 'RAHUL', '', 'TIWARI', 4, 46, 34, 560, 962, '0', '', 'M', 'N', 'N', 277, '2019-10-10', NULL, '0', NULL),
(1055, 1738793, 'E', 'A', 'Mr.', 'PITTALA', '', ' ANJAIAH', 4, 46, 34, 560, 980, '0', '', 'M', 'N', 'N', 277, '2019-10-12', NULL, '0', NULL),
(1056, 1738792, 'E', 'A', 'Mr.', 'GAJULA', '', 'KISHAN', 4, 46, 34, 560, 980, '0', '', 'M', 'N', 'N', 277, '2019-10-11', NULL, '0', NULL),
(1057, 1761183, 'E', 'A', 'Mr.', 'SANTOSH ', '', 'PADHAN', 4, 46, 34, 558, 993, '0', '', 'M', 'N', 'N', 323, '2019-12-01', NULL, '0', NULL),
(1058, 1746204, 'E', 'A', 'Mr.', 'DHANESHWAR', '', 'SAHU', 4, 46, 34, 560, 953, '0', '', 'M', 'N', 'N', 314, '2019-11-01', NULL, '0', NULL),
(1059, 1773885, 'E', 'A', 'Mr.', 'BOYA', '', ' HUSSAINPEERA', 4, 46, 34, 515, 955, '0', '', 'M', 'N', 'N', 318, '2019-12-16', NULL, '0', NULL),
(1060, 1775575, 'E', 'A', 'Mr.', 'SANJEEV ', '', 'KUMAR', 4, 46, 34, 558, 966, '0', '', 'M', 'N', 'N', 343, '2019-12-11', NULL, '0', NULL),
(1061, 1775572, 'E', 'A', 'Mr.', 'NEERAJ ', '', 'KUMAR', 4, 46, 34, 558, 951, '0', '', 'M', 'N', 'N', 344, '2019-12-15', NULL, '0', NULL),
(1062, 1775574, 'E', 'A', 'Mr.', 'SANTOSH', '', ' JENA', 4, 46, 34, 558, 964, '0', '', 'M', 'N', 'N', 313, '2019-12-15', NULL, '0', NULL),
(1063, 1777352, 'E', 'A', 'Mr.', 'MAHENDRA', ' KUMAR ', 'PATEL', 4, 46, 34, 560, 953, '0', '', 'M', 'N', 'N', 345, '2019-12-01', NULL, '0', NULL),
(1064, 1775573, 'E', 'A', 'Mr.', 'SIDDHANT ', '', 'SINGH', 4, 46, 34, 558, 953, '0', '', 'M', 'N', 'N', 312, '2019-12-20', NULL, '0', NULL),
(1065, 1790167, 'E', 'A', 'Mr.', 'KAVALI ', 'PARUSHA', ' RAMUD', 4, 46, 34, 515, 1073, '0', '', 'M', 'N', 'N', 346, '2020-01-01', NULL, '0', NULL),
(1066, 1790003, 'E', 'A', 'Mr.', 'KADARI', '', ' RAGHU', 4, 46, 34, 515, 962, '0', '', 'M', 'N', 'N', 347, '2020-01-01', NULL, '0', NULL),
(1067, 1800352, 'E', 'A', 'Mr.', 'JELLA', '', ' RAJU', 4, 46, 34, 560, 962, '0', '', 'M', 'N', 'N', 277, '2020-02-01', NULL, '0', NULL),
(1068, 1820508, 'E', 'A', 'Mr.', 'NARENDRA ', '', 'KUMAR', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 332, '2020-02-01', NULL, '0', NULL),
(1069, 1820549, 'E', 'A', 'Mr.', 'SRIDHAR ', '', 'PANDUGA', 4, 46, 34, 560, 980, '0', '', 'M', 'N', 'N', 348, '2020-02-22', NULL, '0', NULL),
(1070, 1834440, 'E', 'A', 'Mr.', 'RAM', ' KUMAR ', 'MARKAM', 4, 46, 34, 515, 959, '0', '', 'M', 'N', 'N', 349, '2020-03-01', NULL, '0', NULL),
(1071, 1831019, 'E', 'A', 'Mr.', 'B. ', '', 'DEVENDRA', 4, 46, 34, 515, 955, '0', '', 'M', 'N', 'N', 346, '2020-03-04', NULL, '0', NULL),
(1072, 1831020, 'E', 'A', 'Mr.', 'T. ', '', 'NARSIMHUDU', 4, 46, 34, 560, 955, '0', '', 'M', 'N', 'N', 350, '2020-03-04', NULL, '0', NULL),
(1073, 516, 'E', 'A', 'Mr.', 'MANISH', '', 'SINGH', 4, 46, 34, 566, 955, '9963914137', 'manishsinghvnr@gmail.com', 'M', 'N', 'N', 318, '2015-03-10', NULL, '0', NULL),
(1074, 1005, 'E', 'A', 'Mr.', 'LENKAPPA', '', '.', 1, 61, 2, 249, 947, '7760703534', '', 'M', 'Y', 'N', 204, '2020-05-18', NULL, '239547', NULL),
(1075, 1006, 'E', 'A', 'Mr.', 'PRABHAT', '', 'KUMAR', 1, 65, 6, 255, 915, '9608550755', 'prabhatkumar.vspl@gmail.com', 'M', 'Y', 'N', 59, '2020-05-19', NULL, '421411', NULL),
(1076, 1746205, 'E', 'A', 'Mr.', 'UMESH ', 'PURI', 'GOSWAMI', 4, 46, 29, 500, 0, '834998396', '', 'M', 'N', 'N', 281, '2019-11-01', NULL, '0', NULL),
(1077, 1007, 'E', 'A', 'Mr.', 'PAVAN', 'KUMAR', 'SHARMA', 1, 65, 6, 255, 912, '9329431332', 'pavansharma.vspl@gmail.com', 'M', 'Y', 'N', 38, '2020-05-26', NULL, '505929', NULL),
(1078, 1008, 'E', 'A', 'Mr.', 'SHANKAR', '', 'HONYAL', 1, 71, 2, 2, 7, '9704244485', 'shankar.honyal@vnrseeds.com', 'M', 'Y', 'N', 7, '2020-06-01', NULL, '2247075', NULL),
(1079, 1010, 'E', 'D', 'Mr.', 'NARENDRA', 'KUMAR', 'SHRIVASTAV', 1, 65, 6, 255, 924, '9826246442', 'narendrashrivastava.vspl@gmail.com', 'M', 'Y', 'N', 201, '2020-06-02', '2021-04-16', '420135', NULL),
(1080, 1009, 'E', 'D', 'Mr.', 'SHASHI', 'KUMAR', 'BHUSHAN', 1, 64, 6, 257, 4, '7979802236', 'shashikbhushan.vspl@gmail.com', 'M', 'Y', 'N', 24, '2020-06-01', '2021-05-05', '292895', NULL),
(1081, 1011, 'E', 'A', 'Mr.', 'AJAY', '', 'KUMAR', 1, 64, 6, 257, 449, '9027284399', 'ajaykumar.vspl@gmail.com', 'M', 'Y', 'N', 70, '2020-06-04', NULL, '389495', NULL),
(1082, 1012, 'E', 'A', 'Mr.', 'DEMA', 'VENKATA', 'PRASANTH', 1, 64, 6, 257, 597, '8008906421', 'demavprasanth.vspl@gmail.com', 'M', 'N', 'N', 106, '2020-06-15', NULL, '407605', NULL),
(1083, 1013, 'E', 'A', 'Mr.', 'ARNAB', '', 'PANDIT', 1, 64, 6, 257, 916, '7908890785', 'arnabpandit.vspl@gmail.com', 'M', 'N', 'N', 352, '2020-06-15', NULL, '378647', NULL),
(1084, 1014, 'E', 'A', 'Mr.', 'SANDEEP', 'KUMAR', 'DEWANGAN', 1, 63, 9, 202, 169, '9755691658', 'sandeepdewangan.vspl@gmail.com', 'M', 'Y', 'N', 1, '2020-06-18', NULL, '378635', NULL),
(1085, 1015, 'E', 'A', 'Mr.', 'INAMDAR', 'RIYAJ', 'AYUB', 1, 66, 6, 68, 726, '9604586786', 'inamdarriyaj.vspl@gmail.com', 'M', 'Y', 'N', 353, '2020-06-22', NULL, '641156', NULL),
(1086, 1016, 'E', 'D', 'Mr.', 'ANIRBAN', '', 'CHOUDHURY', 1, 64, 6, 257, 916, '7005655670', 'anirbanchoudhury.vspl@gmail.com', 'M', 'N', 'N', 354, '2020-06-26', '2020-07-14', '449219', NULL),
(1087, 1017, 'E', 'A', 'Mr.', 'SUBHAM', 'KUMAR', 'SAHU', 1, 64, 6, 257, 375, '9583350666', 'subhamsahu.vspl@gmail.com', 'M', 'N', 'N', 162, '2020-07-01', NULL, '365675', NULL),
(1088, 1018, 'E', 'A', 'Mr.', 'ABHISHEK', '', 'MANTRI', 1, 64, 6, 257, 375, '7019376572', 'abhishekmantri.vspl@gmail.com', 'M', 'N', 'N', 250, '2020-07-01', NULL, '365675', NULL),
(1089, 1019, 'E', 'D', 'Mr.', 'SABYASACHI', '', 'NAYAK', 1, 63, 6, 286, 375, '8339991888', 'sabyasachinayak.vspl@gmail.com', 'M', 'N', 'N', 355, '2020-07-01', '2020-12-31', '365675', NULL),
(1090, 1020, 'E', 'A', 'Mr.', 'SHUBHAM', '', 'SINGH', 1, 63, 6, 286, 4, '7380922301', 'shubhamkrsingh.vspl@gmail.com', 'M', 'N', 'N', 33, '2020-07-01', NULL, '365675', NULL),
(1091, 1021, 'E', 'A', 'Mr.', 'SURAMPUDI', '', 'RAJASEKHAR', 1, 61, 3, 568, 695, '9491950258', '', 'M', 'N', 'N', 72, '2020-07-01', NULL, '223545', NULL),
(1092, 1022, 'E', 'A', 'Mr.', 'MUKESH', 'KUMAR', 'CHAURASIYA', 1, 61, 3, 568, 780, '9931087673', 'mukesh.chaurasiya.vspl@gmail.com', 'M', 'Y', 'N', 97, '2020-07-01', NULL, '223545', NULL),
(1093, 1023, 'E', 'A', 'Mr.', 'AMIT', '', 'KUMAR', 1, 61, 3, 568, 754, '9671519011', '', 'M', 'Y', 'N', 8, '2020-07-01', NULL, '231751', NULL),
(1094, 1024, 'E', 'A', 'Mr.', 'RAJESH', '', 'KUMAR', 1, 61, 3, 568, 780, '9198685601', '', 'M', 'Y', 'N', 356, '2020-07-01', NULL, '206976', NULL),
(1095, 1025, 'E', 'A', 'Mr.', 'SAROJ', '', 'KUMAR', 1, 63, 3, 215, 15, '9996932207', 'sarojkumar.vspl@gmail.com', 'M', 'N', 'N', 23, '2020-07-02', NULL, '380075', NULL),
(1096, 1026, 'E', 'A', 'Mr.', 'AKSHAY', '', 'MATHAD', 1, 67, 2, 5, 89, '7795099323', 'akshay.mathad@vnrseeds.com', 'M', 'N', 'N', 7, '2020-07-02', NULL, '540365', NULL),
(1097, 1027, 'E', 'A', 'Mr.', 'BHATT', '', 'PARTH', 1, 67, 2, 5, 89, '9723413369', 'bhatt.parth@vnrseeds.com', 'M', 'N', 'N', 1, '2020-07-06', NULL, '567020', NULL),
(1098, 1028, 'E', 'A', 'Mr.', 'PRAKASH', 'GANGAREDDY', 'BALLEWAR', 1, 64, 24, 237, 263, '9022060484', 'prakashballewar.vspl@gmail.com', 'M', 'N', 'N', 155, '2020-07-13', NULL, '303803', NULL),
(1099, 1029, 'E', 'D', 'Mr.', 'ROHIT', 'B', 'BHANDARI', 1, 63, 6, 286, 261, '8896348682', 'rohitbhandari.vspl@gmail.com', 'M', 'N', 'N', 110, '2020-07-21', '2020-11-01', '365675', NULL),
(1100, 1030, 'E', 'A', 'Mr.', 'SATYA', 'RANJAN', 'MURMU', 1, 63, 6, 286, 731, '8601312647', 'satyaranjan.vspl@gmail.com', 'M', 'N', 'N', 289, '2020-07-21', NULL, '365675', NULL),
(1101, 1031, 'E', 'A', 'Mr.', 'AKASH', '', 'SINGH', 1, 63, 6, 286, 449, '9005383944', 'akashsingh.vspl@gmail.com', 'M', 'N', 'N', 45, '2020-07-21', NULL, '365675', NULL),
(1102, 41, 'E', 'D', 'Mr.', 'VISHAL', '', 'SHARMA', 3, 31, 21, 412, 410, '7999355119', 'vishal.vnrnursery@gmail.com', 'M', 'Y', 'N', 237, '2020-07-01', '2021-06-02', '333167', NULL),
(1103, 1032, 'E', 'A', 'Mr.', 'SURAJ', 'KUMAR', 'VERMA', 1, 63, 25, 169, 366, '9696967562', 'surajverma.vspl@gmail.com', 'M', 'N', 'N', 14, '2020-07-24', NULL, '278155', NULL),
(1104, 1033, 'E', 'D', 'Mr.', 'GULAB', '', 'SINGH', 1, 63, 3, 287, 321, '7753915155', 'gulabsingh.vspl@gmail.com', 'M', 'N', 'N', 2, '2020-08-01', '2020-10-27', '380003', NULL),
(1105, 1035, 'E', 'A', 'Mr.', 'HARIGNANAKRISHNAN', '', '.', 1, 63, 3, 287, 238, '8220705524', 'harignanakrishnan.vspl@gmail.com', 'M', 'N', 'N', 246, '2020-08-04', NULL, '380003', NULL),
(1106, 1034, 'E', 'A', 'Mr.', 'THYAMA', '', 'SURESH', 1, 61, 2, 307, 283, '9505779606', '', 'M', 'N', 'N', 7, '2020-08-01', NULL, '175092', NULL),
(1107, 1036, 'E', 'A', 'Mr.', 'RAJAT', '', 'KUMAR', 1, 63, 3, 287, 15, '8725829280', 'rajatkumar.vspl@gmail.com', 'M', 'N', 'N', 41, '2020-08-04', NULL, '380003', NULL),
(1108, 1037, 'E', 'A', 'Mr.', 'SANDEEP ', 'KUMAR', 'PATEL', 1, 63, 3, 287, 927, '7905413546', 'sandeeppatel.vspl@gmail.com', 'M', 'N', 'N', 10, '2020-08-07', NULL, '380003', NULL),
(1109, 1038, 'E', 'A', 'Mr.', 'RANGANATHA', '', 'T', 1, 67, 2, 250, 601, '8073871767', 'ranganatha.vspl@gmail.com', 'M', 'N', 'N', 1, '2020-08-10', NULL, '340355', NULL),
(1110, 1039, 'E', 'A', 'Mr.', 'MORE', 'SHUBHAM', 'SACCHIDANAND', 1, 65, 6, 492, 14, '7588608169', 'shubhammore.vspl@gmail.com', 'M', 'N', 'N', 357, '2020-08-10', NULL, '600118', NULL),
(1111, 1040, 'E', 'A', 'Mr.', 'RAMAN', '', 'SHARMA', 1, 65, 6, 492, 34, '8954937717', 'ramansharma.vspl@gmail.com', 'M', 'N', 'N', 60, '2020-08-10', NULL, '600118', NULL),
(1112, 1041, 'E', 'A', 'Mr.', 'RAM', '', 'JEEVAN', 1, 63, 3, 287, 143, '9452766473', 'ramjeevan.vspl@gmail.com', 'M', 'N', 'N', 132, '2020-08-11', NULL, '380003', NULL),
(1113, 1042, 'E', 'A', 'Mr.', 'PARTH', '', 'JAIN', 1, 65, 6, 492, 946, '8251990400', 'parthjain.vspl@gmail.com', 'M', 'N', 'N', 23, '2020-08-17', NULL, '600118', NULL),
(1114, 1043, 'E', 'A', 'Mr.', 'SUDHANSU', '', 'ARYA', 1, 63, 3, 287, 927, '8651671817', 'sudhansuarya.vspl@gmail.com', 'M', 'N', 'N', 251, '2020-08-17', NULL, '380003', NULL),
(1115, 1044, 'E', 'A', 'Mr.', 'GANESH', 'SANJAY', 'TAPE', 1, 65, 6, 492, 915, '9970103017', 'ganeshtape.vspl@gmail.com', 'M', 'N', 'N', 108, '2020-08-24', NULL, '600118', NULL),
(1116, 1045, 'E', 'A', 'Mr.', 'ALLE NAGA SARATH', 'CHANDRA', 'REDDY', 1, 67, 2, 5, 89, '9666025173', 'sarathreddy.vspl@gmail.com', 'M', 'N', 'N', 7, '2020-08-24', NULL, '540365', NULL),
(1117, 1046, 'E', 'A', 'Mr.', 'ROHIT', '', 'SHARMA', 1, 65, 6, 492, 946, '9456295890', 'sharmarohit.vspl@gmail.com', 'M', 'Y', 'N', 12, '2020-09-01', NULL, '450042', NULL),
(1118, 1047, 'E', 'A', 'Mr.', 'PARMAR', 'BHIKHUSINH', 'BABUSINH', 1, 61, 4, 10, 73, '9727006812', '', 'M', 'Y', 'N', 90, '2020-09-01', NULL, '175092', NULL),
(1119, 1048, 'E', 'A', 'Mr.', 'PARMAR', 'CHETANKUMAR', 'PRATAPSINH', 1, 61, 4, 32, 73, '7698753745', '', 'M', 'Y', 'N', 90, '2020-09-01', NULL, '175092', NULL),
(1120, 1049, 'E', 'A', 'Mr.', 'PAGI', '', 'AMRUTBHAI', 1, 61, 4, 10, 73, '9913198191', '', 'M', 'Y', 'N', 359, '2020-09-01', NULL, '175092', NULL),
(1121, 1050, 'E', 'A', 'Mr.', 'THAKOR', 'CHATRASINH', 'UDESINH', 1, 61, 4, 10, 73, '9879527236', '', 'M', 'Y', 'N', 270, '2020-09-01', NULL, '175092', NULL),
(1122, 1051, 'E', 'A', 'Dr.', 'ARUN', 'KUMAR', 'RAJBHAR', 1, 64, 25, 169, 361, '7905221774', 'arunkumarrajbhar.vspl@gmail.com', 'M', 'Y', 'Y', 118, '2020-09-08', NULL, '362075', NULL),
(1123, 1052, 'E', 'A', 'Mr.', 'SUDIIP', '', 'AGARAWAAL', 1, 74, 12, 470, 51, '9810869821', 'sudiip.agarawaal@vnrseeds.com', 'M', 'Y', 'N', 1, '2020-09-15', NULL, '4600208', NULL),
(1124, 1053, 'E', 'A', 'Mr.', 'ASHOK', '', 'DAHARIYA', 1, 61, 24, 238, 686, '9752278167', '', 'M', 'Y', 'N', 14, '2020-09-19', NULL, '178970', NULL),
(1125, 1054, 'E', 'D', 'Ms.', 'NUZHAT', '', '.', 1, 62, 24, 365, 543, '9399130416', '', 'F', 'N', 'N', 14, '2020-09-19', '2021-03-12', '193834', NULL),
(1126, 1055, 'E', 'A', 'Mr.', 'VIKRANT', '', 'CHAUHAN', 1, 63, 6, 254, 550, '7536061278', 'vikrantchauhan.vspl10@gmail.com', 'M', 'N', 'N', 134, '2020-09-19', NULL, '263052', NULL),
(1127, 1056, 'E', 'A', 'Mr.', 'BHUPENDRA', '', 'KUMAR', 1, 67, 4, 372, 359, '9412471961', 'bhupendrakumar.vspl@gmail.com', 'M', 'Y', 'N', 94, '2020-09-24', NULL, '700038', NULL),
(1128, 42, 'E', 'A', 'Mr.', 'RAJENDRA', 'KUMAR', 'VERMA', 3, 33, 21, 570, 260, '8770911770', 'rajendra.verma@vnrseeds.in', 'M', 'Y', 'N', 237, '2020-09-01', NULL, '1113252', NULL),
(1129, 43, 'E', 'A', 'Mr.', 'PURAN', 'LAL', 'SAHU', 3, 33, 21, 570, 260, '9981995375', 'puran.sahu@vnrseeds.in', 'M', 'Y', 'N', 361, '2020-09-01', NULL, '1113252', NULL),
(1130, 44, 'E', 'A', 'Mr.', 'TUSHAR', 'KUMAR', 'RATHOD', 3, 33, 21, 570, 1314, '7974349135', 'tushar.rathod@vnrseeds.in', 'M', 'N', 'N', 237, '2020-09-01', NULL, '1021002', NULL),
(1131, 1057, 'E', 'A', 'Mr.', 'PRAVIN', '', '.', 1, 64, 25, 217, 266, '7237057054', 'pravinpatel.vspl@gmail.com', 'M', 'N', 'N', 118, '2020-10-01', NULL, '278155', NULL),
(1132, 1058, 'E', 'A', 'Mr.', 'HARIOM', '', 'YADAV', 1, 64, 25, 217, 361, '7509381993', 'hariomyadav.vspl@gmail.com', 'M', 'N', 'N', 118, '2020-10-01', NULL, '278155', NULL),
(1133, 1059, 'E', 'A', 'Mr.', 'DEEPAK', '', 'DANGI', 1, 63, 25, 169, 361, '8115037242', 'deepakdangi.vspl@gmail.com', 'M', 'N', 'N', 118, '2020-10-01', NULL, '253375', NULL),
(1134, 1060, 'E', 'D', 'Mr.', 'RAHUL', '', 'ADLAK', 1, 63, 25, 169, 463, '6265348640', 'rahuladlak.vspl@gmail.com', 'M', 'N', 'N', 9, '2020-10-01', '2021-01-04', '253375', NULL),
(1135, 1061, 'E', 'D', 'Mr.', 'RAKESH ', 'KUMAR', 'VERMA', 1, 67, 2, 439, 65, '9873794337', 'rakeshverma.vspl@gmail.com', 'M', 'Y', 'N', 1, '2020-10-01', '2021-06-23', '500026', NULL),
(1136, 1062, 'E', 'A', 'Mr.', 'YARUN', '', 'SAHU', 1, 65, 2, 135, 601, '7000280058', 'yarunsahu.vspl@gmail.com', 'M', 'N', 'N', 1, '2020-10-01', NULL, '340355', NULL),
(1137, 1063, 'E', 'A', 'Mr.', 'VIRENDRA', '', 'KUMAR', 1, 64, 25, 217, 366, '9984045804', 'virendrakumar.vspl@gmail.com', 'M', 'Y', 'N', 9, '2020-10-01', NULL, '278155', NULL),
(1138, 1064, 'E', 'A', 'Mr.', 'AJAY', 'KUMAR', 'VISHWAKARMA', 1, 65, 6, 255, 550, '7878949658', 'ajayvishwakarma.vspl@gmail.com', 'M', 'Y', 'N', 128, '2020-10-01', NULL, '586741', NULL),
(1139, 1065, 'E', 'A', 'Mr.', 'SHIVAM', '', 'DWIVEDI', 1, 63, 6, 286, 4, '6387496650', 'shivamdwivedi.vspl@gmail.com', 'M', 'N', 'N', 97, '2020-10-03', NULL, '365075', NULL),
(1140, 1066, 'E', 'A', 'Mr.', 'SURESH', 'KUMAR', 'GUPTA', 1, 65, 6, 255, 4, '8873632247', 'sureshgupta.vspl@gmail.com', 'M', 'Y', 'N', 3, '2020-10-05', NULL, '619385', NULL),
(1141, 1067, 'E', 'A', 'Mr.', 'TARUN', '', 'PARMAR', 1, 63, 4, 169, 359, '7804004143', 'tarunparmar.vspl@gmail.com', 'M', 'N', 'N', 22, '2020-10-08', NULL, '241927', NULL),
(1142, 1068, 'E', 'A', 'Mr.', 'BALKRISHN', '', 'RODVAR', 1, 63, 4, 169, 359, '8827854535', 'balkrishnrodvar.vspl@gmail.com', 'M', 'Y', 'N', 22, '2020-10-08', NULL, '241927', NULL),
(1143, 1069, 'E', 'A', 'Mr.', 'SUNIL', 'KUMAR', 'SHARMA', 1, 66, 6, 68, 4, '8789235132', 'sunilsharma.vspl@gmail.com', 'M', 'Y', 'N', 138, '2020-10-08', NULL, '761680', NULL),
(1144, 1070, 'E', 'A', 'Mr.', 'SHAKIR', '', 'HUSSAIN', 1, 65, 5, 50, 446, '7013435785', 'shakirhussain.vspl@gmail.com', 'M', 'Y', 'N', 155, '2020-10-12', NULL, '362027', NULL),
(1145, 1071, 'E', 'A', 'Mr.', 'K. DILEEP', '', '.', 1, 67, 2, 5, 345, '9441416015', 'kdileep.vspl@gmail.com', 'M', 'N', 'N', 7, '2020-10-12', NULL, '540365', NULL),
(1146, 1072, 'E', 'D', 'Mr.', 'MARGAM', 'BHARATH', 'KUMAR', 1, 67, 2, 5, 89, '9704979035', 'margambharath.vspl@gmail.com', 'M', 'N', 'N', 7, '2020-10-13', '2020-12-26', '540357', NULL),
(1147, 1073, 'E', 'D', 'Mr.', 'HARISH', 'KUMAR', 'SINGH', 1, 64, 6, 257, 34, '9838608094', 'harishkumarsingh.vspl@gmail.com', 'M', 'N', 'N', 71, '2020-10-13', '2021-06-05', '327515', NULL),
(1148, 1074, 'E', 'A', 'Mr.', 'DHARAM', '', 'PAL', 1, 63, 4, 226, 793, '8949064469', 'dharampal.vspl@gmail.com', 'M', 'Y', 'N', 31, '2020-10-15', NULL, '364355', NULL),
(1149, 1075, 'E', 'A', 'Mr.', 'BANDARI', '', 'PRAVEEN', 1, 68, 4, 371, 362, '9963354873', 'praveenbandari.vspl@gmail.com', 'M', 'Y', 'N', 68, '2020-10-24', NULL, '1389670', NULL),
(1150, 1076, 'E', 'A', 'Mr.', 'ARVIND', '', 'KUMAR', 1, 65, 2, 7, 532, '8874664914', 'arvindkumar.vspl@gmail.com', 'M', 'N', 'N', 9, '2020-10-22', NULL, '322355', NULL),
(1151, 1077, 'E', 'A', 'Mr.', 'SHISHIR', '', 'MALL', 1, 65, 6, 492, 252, '7248485756', 'shishirmall.vspl@gmail.com', 'M', 'N', 'N', 87, '2020-10-23', NULL, '600007', NULL),
(1152, 1078, 'E', 'A', 'Mr.', 'HARDIK', '', '.', 1, 65, 6, 492, 584, '7409898048', 'hardik.vspl@gmail.com', 'M', 'N', 'N', 80, '2020-10-23', NULL, '600007', NULL),
(1153, 1079, 'E', 'D', 'Mr.', 'KOYYADA', '', 'MAHENDER', 1, 65, 4, 306, 821, '9912141318', 'kmahender.vspl@gmail.com', 'M', 'Y', 'N', 264, '2020-10-27', '2020-11-17', '265765', NULL),
(1154, 1080, 'E', 'A', 'Mr.', 'BANKELAL', '', '.', 1, 63, 5, 127, 446, '8074088237', 'bankelal.vspl@gmail.com', 'M', 'Y', 'N', 155, '2020-11-02', NULL, '268243', NULL),
(1155, 1081, 'E', 'A', 'Mr.', 'BODDU', '', 'SRIKANTH', 1, 63, 5, 57, 236, '9010292622', 'boddusrikanth.vspl@gmail.com', 'M', 'Y', 'N', 155, '2020-11-02', NULL, '249659', NULL),
(1156, 1082, 'E', 'A', 'Mr.', 'PRAKHAR', '', 'VERMA', 1, 64, 4, 186, 359, '7238831743', 'prakharverma.vspl@gmail.com', 'M', 'N', 'N', 22, '2020-11-02', NULL, '277610', NULL),
(1157, 1083, 'E', 'A', 'Mr.', 'ABHISHEK', '', 'PATRA', 1, 63, 6, 286, 261, '6370825294', 'abhishekpatra.vspl@gmail.com', 'M', 'N', 'N', 256, '2020-11-02', NULL, '365075', NULL),
(1158, 1084, 'E', 'A', 'Mr.', 'SUNIL', '', 'M', 1, 61, 2, 249, 520, '9538007875', 'sunilm.vnrseeds@gmail.com', 'M', 'N', 'N', 204, '2020-11-02', NULL, '204301', NULL),
(1159, 1085, 'E', 'A', 'Dr.', 'KISHAN ', 'KUMAR', 'SHARMA', 1, 67, 2, 250, 65, '8780121625', 'kishansharma.vspl@gmail.com', 'M', 'N', 'Y', 1, '2020-11-05', NULL, '480035', NULL),
(1160, 1850982, 'E', 'A', 'Mr.', 'PRAVEEN ', 'SANNAGOUDA', 'HOTTER', 4, 46, 34, 560, 992, '0', '', 'M', 'N', 'N', 365, '2020-06-10', NULL, '0', NULL),
(1161, 1882934, 'E', 'A', 'Mr.', 'KHILESHWAR', '', 'SAHU', 4, 46, 34, 571, 959, '0', '', 'M', 'N', 'N', 310, '2020-09-01', NULL, '0', NULL),
(1162, 1882935, 'E', 'A', 'Mr.', 'RANJAN', 'KUMAR ', 'PATRA', 4, 46, 34, 571, 961, '0', '', 'M', 'N', 'N', 311, '2020-09-25', NULL, '0', NULL),
(1163, 1901292, 'E', 'A', 'Mr.', 'SUJIT ', 'KUMAR ', 'MANSINGH', 4, 46, 34, 560, 0, '0', '', 'M', 'N', 'N', 366, '2020-09-25', NULL, '0', NULL),
(1164, 1900939, 'E', 'A', 'Mr.', 'THAKOR ', 'GANPAT', 'SHAHBHAI', 4, 46, 34, 560, 992, '0', '', 'M', 'N', 'N', 367, '2020-10-01', NULL, '0', NULL),
(1165, 1912857, 'E', 'A', 'Mr.', 'GAUTAM', '', 'BARIK', 4, 46, 34, 560, 1204, '0', '', 'M', 'N', 'N', 368, '2020-10-04', NULL, '0', NULL),
(1166, 1912859, 'E', 'A', 'Mr.', 'BRAJA ', 'KISHORE', ' DEY', 4, 46, 34, 560, 1205, '0', '', 'M', 'N', 'N', 369, '2020-10-04', NULL, '0', NULL),
(1167, 1086, 'E', 'A', 'Mr.', 'GUNDA', 'BOINA', 'PRASHANTH', 1, 64, 4, 306, 1168, '8096301456', 'gprashanth.vspl@gmail.com', 'M', 'N', 'N', 362, '2020-11-09', NULL, '338027', NULL),
(1168, 1087, 'E', 'A', 'Mr.', 'VIJENDRA', 'SINGH', 'CHOPRA', 1, 69, 4, 427, 362, '9010961000', 'vijendrachopra.vspl@gmail.com', 'M', 'Y', 'N', 22, '2020-11-09', NULL, '1725019', NULL),
(1169, 1088, 'E', 'A', 'Mr.', 'VIKAS', '', 'YADAV', 1, 63, 4, 226, 667, '8299086889', 'vikasyadav25.vspl@gmail.com', 'M', 'N', 'N', 242, '2020-11-13', NULL, '241927', NULL),
(1170, 1089, 'E', 'A', 'Mr.', 'NIRAVKUMAR', 'HASMUKHBHAI', 'THAKOR', 1, 67, 2, 5, 209, '8141811848', 'niravthakor.vspl@gmail.com', 'M', 'N', 'N', 12, '2020-11-17', NULL, '540365', NULL),
(1171, 1912863, 'E', 'A', 'Mr.', 'PARESH ', 'CHANDRA', ' ROUT', 4, 46, 34, 560, 1205, '7064521267', '', 'M', 'N', 'N', 370, '2020-10-04', NULL, '0', NULL),
(1172, 1911314, 'E', 'A', 'Mr.', 'BURRA ', '', 'SRINIVAS', 4, 46, 34, 560, 980, '9959041640', '', 'M', 'N', 'N', 348, '2020-10-07', NULL, '0', NULL),
(1173, 1911316, 'E', 'A', 'Mr.', 'MEKALA', ' PRAMOD ', 'KUMAR', 4, 46, 34, 560, 962, '8008062248', '', 'M', 'N', 'N', 371, '2020-10-07', NULL, '0', NULL),
(1174, 1912657, 'E', 'A', 'Mr.', 'BURRA ', 'SHIVA ', 'KUMAR', 4, 46, 34, 560, 980, '8790464207', '', 'M', 'N', 'N', 372, '2020-10-07', NULL, '0', NULL),
(1175, 1912659, 'E', 'A', 'Mr.', 'PUDARI ', '', 'ANIL', 4, 46, 34, 560, 1203, '9676535668', '', 'M', 'N', 'N', 373, '2020-10-07', NULL, '0', NULL),
(1176, 1912661, 'E', 'A', 'Mr.', 'AMMULA ', '', 'RAJU', 4, 46, 34, 560, 1206, '6281600564', '', 'M', 'N', 'N', 374, '2020-10-07', NULL, '0', NULL),
(1177, 1912864, 'E', 'A', 'Mr.', 'SHERI ', '', 'RAJU', 4, 46, 34, 560, 1203, '8179506774', '', 'M', 'N', 'N', 375, '2020-10-07', NULL, '0', NULL),
(1178, 1930185, 'E', 'A', 'Mr.', 'BHOJENDRA ', 'KUMAR ', 'SAHU', 4, 46, 34, 558, 959, '9669149967', '', 'M', 'N', 'N', 376, '2020-10-24', NULL, '0', NULL),
(1179, 1930183, 'E', 'A', 'Mr.', 'DINESH ', 'KUMAR ', 'SAHU', 4, 46, 34, 558, 959, '6265502450', '', 'M', 'N', 'N', 377, '2020-10-24', NULL, '0', NULL),
(1180, 1930186, 'E', 'A', 'Mr.', 'DIVESH', '', '.', 4, 46, 34, 558, 959, '7905203231', '', 'M', 'N', 'N', 378, '2020-10-24', NULL, '0', NULL),
(1181, 1930181, 'E', 'A', 'Mr.', 'MANISH', '', ' GAUD', 4, 46, 34, 558, 959, '7460097093', '', 'M', 'N', 'N', 380, '2020-10-24', NULL, '0', NULL),
(1182, 1921113, 'E', 'A', 'Mr.', 'RAMANCHA ', '', 'MOGILAIAH', 4, 46, 34, 560, 980, '8919538553', '', 'M', 'N', 'N', 381, '2020-10-12', NULL, '0', NULL),
(1183, 1921114, 'E', 'A', 'Mr.', 'SHAIK ', '', 'SHABBEER', 4, 46, 34, 560, 962, '6301843492', '', 'M', 'N', 'N', 382, '2020-10-18', NULL, '0', NULL),
(1184, 1933693, 'E', 'A', 'Mr.', 'THATIPAMULA ', '', 'NARSIMLU', 4, 46, 34, 561, 1203, '8074378580', '', 'M', 'N', 'N', 383, '2020-10-27', NULL, '0', NULL),
(1185, 1933694, 'E', 'A', 'Mr.', 'YANTRAPATI', 'GIRI ', 'BABU', 4, 46, 34, 560, 992, '9912278705', '', 'M', 'N', 'N', 384, '2020-11-02', NULL, '0', NULL),
(1186, 1932118, 'E', 'A', 'Mr.', 'VADLURI ', '', 'SRIHARI', 4, 46, 34, 560, 1203, '9000941642', '', 'M', 'N', 'N', 383, '2020-11-02', NULL, '0', NULL),
(1187, 1932117, 'E', 'A', 'Mr.', 'LAVUDIYA ', '', 'SWAMY', 4, 46, 34, 560, 1207, '9177118643', '', 'M', 'N', 'N', 385, '2020-11-02', NULL, '0', NULL),
(1188, 1933898, 'E', 'A', 'Mr.', 'BOYA', '', ' HUSSAINPEERA', 4, 46, 34, 560, 1208, '7702403561', '', 'M', 'N', 'N', 386, '2020-11-02', NULL, '0', NULL),
(1189, 1933896, 'E', 'A', 'Mr.', 'B. ', 'ANIL', ' KUMAR', 4, 46, 34, 515, 1073, '9346633593', '', 'M', 'N', 'N', 387, '2020-11-02', NULL, '0', NULL),
(1190, 1933899, 'E', 'A', 'Mr.', 'SOOLA ', 'VENU ', 'GOPAL', 4, 46, 34, 515, 1073, '8465907438', '', 'M', 'N', 'N', 387, '2020-11-02', NULL, '0', NULL),
(1191, 1933897, 'E', 'A', 'Mr.', 'MANDLA ', 'TULASI ', 'RAM', 4, 46, 34, 565, 955, '9441007403', '', 'M', 'N', 'N', 388, '2020-11-02', NULL, '0', NULL),
(1192, 1933645, 'E', 'A', 'Mr.', 'CHAKILAM ', '', 'SAINIHAR', 4, 46, 34, 565, 1203, '7093104653', '', 'M', 'N', 'N', 383, '2020-11-02', NULL, '0', NULL),
(1193, 1933644, 'E', 'A', 'Mr.', 'AJAY', '', ' DHAKAD', 4, 46, 34, 560, 1006, '9575959737', '', 'M', 'N', 'N', 347, '2020-11-05', NULL, '0', NULL),
(1194, 1933646, 'E', 'A', 'Mr.', 'NIRMAL ', '', 'KUSHWAH', 4, 46, 34, 560, 1006, '8349242897', '', 'M', 'N', 'N', 346, '2020-11-05', NULL, '0', NULL),
(1195, 1933900, 'E', 'A', 'Mr.', 'SANGEET ', '', 'REWAPATI', 4, 46, 34, 560, 1006, '8299309337', '', 'M', 'N', 'N', 390, '2020-11-05', NULL, '0', NULL),
(1196, 1934525, 'E', 'A', 'Mr.', 'ABHISHEK ', '', 'VERMA', 4, 46, 34, 560, 908, '8840733989', '', 'M', 'N', 'N', 281, '2020-11-02', NULL, '0', NULL),
(1197, 1934527, 'E', 'A', 'Mr.', 'RAJENDRA ', 'KUMAR ', 'VERMA', 4, 46, 34, 560, 908, '7905565506', '', 'M', 'N', 'N', 281, '2020-11-02', NULL, '0', NULL),
(1198, 1937306, 'E', 'A', 'Mr.', 'PAWAN ', '', 'VERMA', 4, 46, 34, 558, 951, '9793783022', '', 'M', 'N', 'N', 312, '2020-11-02', NULL, '0', NULL),
(1199, 1937307, 'E', 'A', 'Mr.', 'AMIT', '', ' KUMAR', 4, 46, 34, 558, 951, '7770854401', '', 'M', 'N', 'N', 281, '2020-11-03', NULL, '0', NULL),
(1200, 1937342, 'E', 'A', 'Mr.', 'VEDPRAKASH ', '', 'DARRO', 4, 46, 34, 558, 959, '7089884571', '', 'M', 'N', 'N', 391, '2020-11-05', NULL, '0', NULL),
(1201, 1940403, 'E', 'A', 'Mr.', 'PONNAGANTI ', '', 'ARJUN', 4, 46, 34, 560, 1203, '9492643280', '', 'M', 'N', 'N', 373, '2020-11-11', NULL, '0', NULL),
(1202, 1940402, 'E', 'A', 'Mr.', 'DONGALA ', '', 'SAMMAIAH', 4, 46, 34, 560, 962, '9000010487', '', 'M', 'N', 'N', 390, '2020-11-11', NULL, '0', NULL),
(1203, 1075, 'E', 'A', 'Mr.', 'BANDARI ', '', 'PRAVEEN', 4, 46, 34, 556, 952, '9963354873', 'praveenbandari.vspl@gmail.com', 'M', 'N', 'N', 390, '2020-10-24', NULL, '0', NULL),
(1204, 916, 'E', 'A', 'Mr.', 'SOHIT', '', 'PAL', 4, 46, 34, 561, 957, '7895316768', '', 'M', 'N', 'N', 309, '2019-09-23', NULL, '0', NULL);
INSERT INTO `master_employee` (`EmployeeID`, `EmpCode`, `EmpType`, `EmpStatus`, `Title`, `Fname`, `Sname`, `Lname`, `CompanyId`, `GradeId`, `DepartmentId`, `DesigId`, `RepEmployeeID`, `Contact`, `Email`, `Gender`, `Married`, `DR`, `Location`, `DOJ`, `DateOfSepration`, `CTC`, `LastUpdated`) VALUES
(1205, 914, 'E', 'A', 'Mr.', 'SAMBIT', '', 'PADHI', 4, 46, 34, 561, 957, '8328998657', '', 'M', 'N', 'N', 309, '2019-09-23', NULL, '0', NULL),
(1206, 175, 'E', 'A', 'Mr.', 'MUDUGUNT', ' RAMA KRISHNA', 'REDDY', 4, 46, 34, 561, 0, '9866808471', '', 'M', 'N', 'N', 277, '2008-07-21', NULL, '0', NULL),
(1207, 1087, 'E', 'A', 'Mr.', 'CHOPRA', 'VIJENDRA ', 'SING', 4, 46, 34, 555, 0, '9010961000', '', 'M', 'N', 'N', 278, '2020-11-09', NULL, '0', NULL),
(1208, 994, 'E', 'A', 'Mr.', 'ALLETI', '', ' SANDEEP', 4, 46, 34, 561, 0, '8179152212', '', 'M', 'N', 'N', 318, '2020-03-12', NULL, '0', NULL),
(1209, 1090, 'E', 'A', 'Mr.', 'GUTTI', 'SARDESH', 'RANA', 1, 67, 2, 5, 283, '9872838621', 'sardeshrana.vspl@gmail.com', 'M', 'N', 'N', 7, '2020-11-20', NULL, '540365', NULL),
(1210, 1091, 'E', 'A', 'Mr.', 'SAURABH', '', 'AVASTHI', 1, 65, 4, 306, 1168, '9528202986', 'saurabhavasthi.vspl@gmail.com', 'M', 'Y', 'N', 362, '2020-11-21', NULL, '357227', NULL),
(1211, 1092, 'E', 'A', 'Mr.', 'VIKAS', '', 'SINGH', 1, 63, 25, 169, 416, '8218582320', 'vikassingh.vspl@gmail.com', 'M', 'N', 'N', 63, '2020-11-23', NULL, '253375', NULL),
(1212, 1093, 'E', 'A', 'Mr.', 'AAKASH', '', 'PATLYA', 1, 64, 4, 186, 145, '8357080208', 'aakashpatlya.vspl@gmail.com', 'M', 'N', 'N', 99, '2020-11-24', NULL, '277610', NULL),
(1213, 127, 'E', 'D', 'Mr.', 'TALMALIYA YADAV', '', '', 1, 3, 5, 234, 0, '0', '', 'M', 'N', 'N', 1, '2008-01-18', '2012-10-04', '0', NULL),
(1214, 196, 'E', 'D', 'Mr.', 'T.RAVINDRA', '', '', 1, 9, 6, 66, 0, '0', '', 'M', 'N', 'N', 1, '2008-10-10', '2018-06-30', '0', NULL),
(1215, 198, 'E', 'D', 'Mr.', 'NANDKISHORE KUMAR', '', '', 1, 3, 6, 70, 0, '0', '', 'M', 'N', 'N', 1, '2008-10-11', '2012-01-05', '0', NULL),
(1216, 202, 'E', 'D', 'Mr.', 'RAJESH  KUMAR KUSHWAHA', '', '', 1, 3, 6, 70, 0, '0', '', 'M', 'N', 'N', 1, '2008-11-01', '2012-01-05', '0', NULL),
(1217, 234, 'E', 'D', 'Mr.', 'SRINIVAS P.Y', '', '', 1, 2, 6, 70, 0, '0', '', 'M', 'N', 'N', 1, '2009-04-20', '2012-04-24', '0', NULL),
(1218, 336, 'E', 'D', 'Mr.', 'AMIT KUMAR VERMA', '', '', 1, 2, 5, 59, 0, '0', '', 'M', 'N', 'N', 1, '2011-03-17', '2011-03-26', '0', NULL),
(1219, 359, 'E', 'D', 'Mr.', 'KRISHNANANDA PRALHAD INGLE', '', '', 1, 6, 2, 6, 0, '0', '', 'M', 'N', 'N', 1, '2011-09-20', '2012-05-29', '0', NULL),
(1220, 391, 'E', 'D', 'Mr.', 'MOHD.SHADHULLA BABA', '', '', 1, 3, 5, 126, 0, '0', '', 'M', 'N', 'N', 1, '2012-08-10', '2012-12-24', '0', NULL),
(1224, 1094, 'E', 'A', 'Mr.', 'KODI ', '', 'ABBULU', 1, 65, 4, 306, 820, '8985786437', 'kabbulu.vspl@gmail.com', 'M', 'Y', 'N', 218, '2020-12-01', NULL, '370055', NULL),
(1225, 1095, 'E', 'A', 'Mr.', 'SANDIP', 'DINKAR', 'NISTANE', 1, 65, 6, 255, 913, '9545773317', 'sandipdnistane.vspl@gmail.com', 'M', 'Y', 'N', 46, '2020-12-01', NULL, '420635', NULL),
(1226, 1096, 'E', 'A', 'Mr.', 'GAMI', 'PANKAJKUMAR', 'BABUBHAI', 1, 67, 2, 5, 179, '9537246768', 'pankajgami.vspl@gmail.com', 'M', 'N', 'N', 7, '2020-12-01', NULL, '540365', NULL),
(1227, 1097, 'E', 'A', 'Mr.', 'SANDEEP', '', 'KUMAR', 1, 63, 3, 215, 321, '8445006935', 'sandeepkumar.vspl@gmail.com', 'M', 'N', 'N', 2, '2020-12-01', NULL, '350027', NULL),
(1228, 1098, 'E', 'A', 'Mr.', 'SUDIP', '', 'BAROI', 1, 63, 6, 254, 916, '9401260214', 'sudipbaroi.vspl@gmail.com', 'M', 'N', 'N', 354, '2020-12-01', NULL, '340355', NULL),
(1229, 1099, 'E', 'A', 'Dr.', 'SHRIPAD', 'MADHUKARRAO', 'JOSHI', 1, 70, 2, 266, 601, '9822683657', 'shripad.joshi@vnrseeds.com', 'M', 'Y', 'Y', 1, '2020-12-02', NULL, '1250087', NULL),
(1230, 1100, 'E', 'A', 'Mr.', 'SAMRAT', '', 'GUPTA', 1, 63, 7, 207, 28, '8770686880', 'samratgupta93.vspl@gmail.com', 'M', 'N', 'N', 1, '2020-12-02', NULL, '265765', NULL),
(1231, 1101, 'E', 'D', 'Mr.', 'VIJAY', '', 'KUMAR', 1, 64, 4, 306, 309, '8604818662', 'vijaykumar05.vspl@gmail.com', 'M', 'Y', 'N', 22, '2020-12-10', '2021-01-02', '314027', NULL),
(1232, 1102, 'E', 'A', 'Mr.', 'BANDA', 'SRINIVAS', 'REDDY', 1, 63, 2, 131, 108, '9849563932', 'bsrinivasreddy.vspl@gmail.com', 'M', 'Y', 'N', 7, '2020-12-16', NULL, '422049', NULL),
(1233, 45, 'E', 'A', 'Mr.', 'DEEPAK', 'KUMAR', 'YADAV', 3, 31, 21, 625, 410, '7067875687', 'deepakyadav.vnrnursery@gmail.com', 'M', 'N', 'N', 394, '2020-12-22', NULL, '322355', NULL),
(1234, 46, 'E', 'A', 'Mr.', 'VIBHOR', '', 'AGARWAL', 3, 31, 21, 625, 1128, '9808617153', 'vibhoragarwal.vnrnursery@gmail.com', 'M', 'N', 'N', 237, '2020-12-23', NULL, '322007', NULL),
(1235, 1103, 'E', 'A', 'Mr.', 'RAJPUT', 'AJITSINH', 'BHAMARSINH', 1, 67, 44, 575, 52, '9974769428', 'ajitsinhrajput.vspl@gmail.com', 'M', 'N', 'N', 7, '2021-01-05', NULL, '420012', NULL),
(1236, 1104, 'E', 'A', 'Mr.', 'LAXMINARAYAN', '', '.', 1, 64, 5, 438, 246, '7803079699', 'laxminarayan.vspl@gmail.com', 'M', 'Y', 'N', 14, '2021-01-11', NULL, '252644', NULL),
(1237, 1105, 'E', 'A', 'Ms.', 'SOMYA', '', 'AGARWAL', 1, 66, 2, 6, 601, '9621626848', 'somyaagarwal.vspl@gmail.com', 'F', 'N', 'N', 1, '2021-01-11', NULL, '422049', NULL),
(1238, 1106, 'E', 'A', 'Ms.', 'SUPRIYA', '', 'NAYAK', 1, 66, 2, 6, 601, '8602080298', 'supriyanayak.vspl@gmail.com', 'F', 'N', 'N', 1, '2021-01-11', NULL, '422049', NULL),
(1239, 1752099, 'E', 'A', 'Mr.', 'THADIGOPPULA ', '', 'AJAY', 4, 46, 29, 576, 948, '0', '', 'M', 'N', 'N', 277, '2019-11-01', NULL, '0', NULL),
(1240, 1761844, 'E', 'A', 'Mr.', 'DIPENDRA', '', '.', 4, 46, 29, 500, 0, '0', '', 'M', 'N', 'N', 396, '2019-12-01', NULL, '0', NULL),
(1241, 1789029, 'E', 'A', 'Mr.', 'YOGESH ', '', 'KUMAR', 4, 46, 39, 504, 897, '0', '', 'M', 'N', 'N', 274, '2020-01-15', NULL, '0', NULL),
(1242, 1742818, 'E', 'A', 'Ms.', 'SANCHITA', '', ' ROUT', 4, 46, 31, 577, 894, '0', '', 'F', 'N', 'N', 273, '2019-11-05', NULL, '0', NULL),
(1243, 1761184, 'E', 'D', 'Mr.', 'PAWAN ', 'KUMAR ', 'MISHRA', 4, 46, 33, 578, 888, '0', '', 'M', 'N', 'N', 274, '2019-12-09', NULL, '0', NULL),
(1244, 1807641, 'E', 'A', 'Mr.', 'BHASKAR', '', ' RAO', 4, 46, 33, 508, 901, '0', '', 'M', 'N', 'N', 274, '2020-02-01', NULL, '0', NULL),
(1245, 1820557, 'E', 'A', 'Mr.', 'HEMCHAND ', '', 'PATEL', 4, 46, 33, 579, 1246, '0', '', 'M', 'N', 'N', 274, '2020-02-01', NULL, '0', NULL),
(1246, 144, 'E', 'A', 'Mr.', 'RAVINDRA ', '', 'YADAV', 4, 79, 33, 534, 0, '0', '', 'M', 'N', 'N', 274, '2008-03-20', NULL, '0', NULL),
(1247, 1811502, 'E', 'A', 'Mr.', 'MUKESH ', 'KUMAR', ' KAUSHIK', 4, 46, 33, 508, 899, '0', '', 'M', 'N', 'N', 274, '2020-02-01', NULL, '0', NULL),
(1248, 1844619, 'E', 'A', 'Mr.', 'SUJIT KUMAR', '', ' KUMAR', 4, 46, 33, 580, 901, '0', '', 'M', 'N', 'N', 274, '2020-05-15', NULL, '0', NULL),
(1249, 1107, 'E', 'A', 'Mr.', 'VINEET ', 'KUMAR', 'SINGH', 1, 64, 27, 583, 354, '9808540707', 'vineetsingh.vspl@gmail.com', 'M', 'Y', 'N', 22, '2021-01-11', NULL, '350003', NULL),
(1250, 1706634, 'E', 'A', 'Mr.', 'SAURABH', '', 'KUMAR', 4, 46, 41, 516, 1251, '0', '', 'M', 'N', 'N', 275, '2019-09-02', NULL, '0', NULL),
(1251, 468, 'E', 'A', 'Mr.', 'KADARI', '', 'SHANKAR', 4, 46, 41, 581, 0, '0', '', 'M', 'N', 'N', 275, '2014-04-01', NULL, '0', NULL),
(1252, 1701875, 'E', 'A', 'Mr.', 'CHARITRA ', '', 'CHAUDHARY', 4, 46, 34, 565, 1253, '0', '', 'M', 'N', 'N', 397, '2019-09-02', NULL, '0', NULL),
(1253, 10002, 'E', 'A', 'Mr.', 'VIMAL', '', 'CHAWDA', 4, 46, 37, 582, 0, '0', '', 'M', 'N', 'N', 273, '2005-04-01', NULL, '0', NULL),
(1254, 1108, 'E', 'A', 'Mr.', 'YOGESH', 'ARUN', 'SHINDE', 1, 67, 2, 5, 89, '8605324807', 'yogeshshinde.vspl@gmail.com', 'M', 'Y', 'N', 1, '2021-01-15', NULL, '540365', NULL),
(1255, 1109, 'E', 'A', 'Mr.', 'BABASAHEB ', 'BHANUDAS ', 'LAGE', 1, 64, 3, 215, 321, '9689501766', 'babasahebblage.vspl@gmail.com', 'M', 'N', 'N', 46, '2021-01-18', NULL, '368027', NULL),
(1256, 1110, 'E', 'A', 'Mr.', 'RAHUL', '', 'KUMAR', 1, 65, 5, 50, 52, '9616383006', 'rahulkumar.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-01-20', NULL, '222507', NULL),
(1257, 1111, 'E', 'A', 'Mr.', 'MEWA', 'RAM', 'VISHWAKARMA', 1, 65, 2, 6, 601, '7747851749', 'mewaram.vspl@gmail.com', 'M', 'Y', 'N', 196, '2021-01-21', NULL, '322355', NULL),
(1258, 1112, 'E', 'A', 'Mr.', 'SUHAS', 'PRAKASH', ' JADHAV', 1, 65, 6, 255, 913, '7774036112', 'suhaspjadhav.vspl@gmail.com', 'M', 'Y', 'N', 96, '2021-01-25', NULL, '654729', NULL),
(1259, 1811519, 'E', 'A', 'Mr.', 'JABISKO', '', ' VERMA', 4, 46, 42, 584, 1260, '6386976845', 'Verjabisko123@gmail.com', 'M', 'N', 'N', 398, '2020-02-01', NULL, '0', NULL),
(1260, 493, 'E', 'A', 'Mr.', 'RAHUL', '', ' PATIDAR', 4, 46, 42, 586, 888, '8238767222', 'rahul.patidar@vnrseeds.com', 'M', 'N', 'N', 274, '2014-09-22', NULL, '0', NULL),
(1261, 1807999, 'E', 'A', 'Mr.', 'JINUKA ', '', 'ANIL', 4, 46, 42, 508, 1262, '7893638535', '', 'M', 'N', 'N', 384, '2020-02-01', NULL, '0', NULL),
(1262, 427, 'E', 'A', 'Mr.', 'KUSH', 'DATT ', 'RAWAT', 4, 46, 42, 586, 888, '9981995345', '', 'M', 'N', 'N', 278, '2013-07-01', NULL, '0', NULL),
(1263, 1808119, 'E', 'A', 'Mr.', 'JITENDRA', ' KUMAR', ' VERMA', 4, 46, 42, 587, 1262, '9621025622', '', 'M', 'N', 'N', 399, '2020-02-01', NULL, '0', NULL),
(1264, 1831021, 'E', 'A', 'Mr.', 'SRIDHAR ', 'SIDNEY ', 'MALLELA', 4, 46, 42, 508, 1262, '9553059693', '', 'M', 'N', 'N', 400, '2020-03-01', NULL, '0', NULL),
(1265, 329, 'E', 'A', 'Mr.', 'AJAY ', 'KUMAR ', 'DEWANGAN', 4, 46, 31, 528, 894, '8602190312', 'ajaykumar.dewangan@vnrseeds.in', 'M', 'N', 'N', 273, '2011-02-11', NULL, '0', NULL),
(1266, 412, 'E', 'A', 'Mr.', 'SHEKHAR', 'CHANDRA ', 'SATI', 4, 46, 41, 588, 0, '9981993070', '', 'M', 'N', 'N', 274, '2013-02-15', NULL, '0', NULL),
(1267, 624, 'E', 'A', 'Mr.', 'RAHUL', '', ' AGRAWAL', 4, 46, 39, 589, 897, '8839378252', '', 'M', 'N', 'N', 274, '2016-10-18', NULL, '0', NULL),
(1268, 1940405, 'E', 'A', 'Mr.', 'RAVINDRA', 'KUMAR', ' YADAV', 4, 46, 33, 534, 888, '8085158034', '', 'M', 'N', 'N', 274, '2008-03-20', NULL, '0', NULL),
(1269, 1113, 'E', 'A', 'Mr.', 'RAHUL', '', 'SINHA', 1, 63, 9, 202, 169, '9770866241', 'rahulsinha.vspl@gmail.com', 'M', 'Y', 'N', 1, '2021-02-01', NULL, '380075', NULL),
(1270, 1114, 'E', 'A', 'Mr.', 'PRAVIN', 'DHANRAJ', 'CHAVAN', 1, 65, 24, 237, 382, '9322058293', 'pravinchavan.vspl@gmail.com', 'M', 'Y', 'N', 14, '2021-02-19', NULL, '483201', NULL),
(1271, 1115, 'E', 'A', 'Mr.', 'PRADEEP ', 'KUMAR', 'VERMA', 1, 63, 25, 169, 361, '9919801800', 'pradeepverma.vspl@gmail.com', 'M', 'N', 'N', 118, '2021-02-20', NULL, '223069', NULL),
(1272, 1116, 'E', 'A', 'Mr.', 'DEBABRATA', '', 'MOHARANA', 1, 64, 6, 257, 375, '7978983461', 'debabratamoharana.vspl@gmail.com', 'M', 'N', 'N', 401, '2021-02-25', NULL, '365675', NULL),
(1273, 1117, 'E', 'A', 'Mr.', 'VENKATESH ', '', 'NAYAK', 1, 65, 6, 255, 718, '7899150455', 'venkateshnayak.vspl@gmail.com', 'M', 'Y', 'N', 217, '2021-02-25', NULL, '665074', NULL),
(1274, 1118, 'E', 'A', 'Mr.', 'AAKASH', 'KUMAR ', 'MASRAM', 1, 64, 7, 207, 28, '9713401309', 'aakashmeshramvspl@gmail.com', 'M', 'N', 'N', 1, '2021-03-01', NULL, '302075', NULL),
(1275, 1119, 'E', 'A', 'Mr.', 'NAKKALAPALLY', '', 'BALARAJU', 1, 61, 2, 307, 748, '9502328385', '', 'M', 'N', 'N', 7, '2021-03-01', NULL, '175092', NULL),
(1276, 1120, 'E', 'A', 'Mr.', 'SRAVANSAI', 'KUMAR', 'RAYIPELLI', 1, 63, 6, 286, 220, '9493838090', 'sravansaikrayipelli.vspl@gmail.com', 'M', 'N', 'N', 298, '2021-03-01', NULL, '450035', NULL),
(1277, 1121, 'E', 'A', 'Ms.', 'PAPIA', '', 'GOSWAMI', 1, 64, 5, 396, 52, '9874159405', 'papiagoswami.vspl@gmail.com', 'F', 'N', 'N', 403, '2021-03-03', NULL, '340355', NULL),
(1278, 1122, 'E', 'A', 'Mr.', 'IMRAN', '', 'KHAN', 1, 61, 5, 590, 246, '7828520717', 'imrankhan.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-03-09', NULL, '175092', NULL),
(1279, 1123, 'E', 'A', 'Mr.', 'SOUMYA', 'RANJAN', 'MAHAPATRA', 1, 64, 6, 257, 375, '7978512226', 'soumyaranjan.vspl@gmail.com', 'M', 'N', 'N', 404, '2021-03-10', NULL, '365675', NULL),
(1280, 1124, 'E', 'A', 'Mr.', 'ABHISHEK', 'KUMAR', 'PANDEY', 1, 67, 1, 199, 142, '9098288898', 'abhishekkumar.pandey@vnrseeds.com', 'M', 'Y', 'N', 1, '2021-03-12', NULL, '600069', NULL),
(1281, 47, 'E', 'A', 'Mr.', 'SHIVANI', 'SMITA', 'SADANAND', 3, 31, 21, 625, 410, '8827627377', 'shivani.vnrnursery@gmail.com', 'M', 'N', 'N', 103, '2021-03-15', NULL, '340355', NULL),
(1282, 1125, 'E', 'A', 'Ms.', 'AYUSHI', '', 'PRAJAPATI', 1, 63, 25, 614, 195, '8528041493', 'ayushiprajapati.vspl@gmail.com', 'F', 'N', 'N', 14, '2021-04-01', NULL, '277659', NULL),
(1283, 1126, 'E', 'A', 'Ms.', 'MONIKONDA', '', 'MONIKA', 1, 64, 5, 396, 81, '8160197245', 'monikaplant.vspl@gmail.com', 'F', 'N', 'N', 155, '2021-04-01', NULL, '308003', NULL),
(1284, 1127, 'E', 'A', 'Mr.', 'MO. SAIF', '', 'AHMAD', 1, 63, 5, 593, 20, '7974456849', 'saifahmad.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-04-01', NULL, '188268', NULL),
(1285, 1128, 'E', 'A', 'Mr.', 'DINESH ', 'KUMAR', 'GAYAKWAD', 1, 63, 5, 593, 20, '9752930119', 'dineshgaykwad.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-04-01', NULL, '188268', NULL),
(1286, 1129, 'E', 'A', 'Mr.', 'VASUDEV', '', '.', 1, 63, 5, 121, 205, '7247487137', 'vasudev.vspl@gmail.com', 'M', 'Y', 'N', 14, '2021-04-01', NULL, '230626', NULL),
(1287, 1130, 'E', 'A', 'Mr.', 'DEEPAK', '', 'SHARMA', 1, 65, 6, 492, 4, '7356679956', 'deepaksharma02.vspl@gmail.com', 'M', 'N', 'N', 67, '2021-04-05', NULL, '600007', NULL),
(1288, 1131, 'E', 'A', 'Dr.', 'TIRULAMA JAWAHAR', 'SRI', 'GOPI', 1, 68, 2, 5, 89, '9393998789', 'jawahar.vspl@gmail.com', 'M', 'N', 'Y', 7, '2021-04-07', NULL, '720004', NULL),
(1289, 48, 'E', 'A', 'Mr.', 'ABHISHEK', '', 'JAIN', 3, 31, 19, 615, 445, '7000512625', 'abhishekjain.vnrnursery@gmail.com', 'M', 'N', 'N', 102, '2021-04-08', NULL, '322355', NULL),
(1290, 49, 'E', 'A', 'Mr.', 'NEETESH ', '', 'RAGHUWANSHI', 3, 31, 19, 615, 445, '8319947670', 'neeteshraghuwanshi.vnrnursery@gmail.com', 'M', 'N', 'N', 102, '2021-04-08', NULL, '322355', NULL),
(1291, 1132, 'E', 'A', 'Mr.', 'ANKIT', '', 'CHOUDHARY', 1, 65, 6, 255, 584, '9713150501', 'ankitchoudhary.vspl@gmail.com', 'M', 'N', 'N', 238, '2021-04-12', NULL, '507635', NULL),
(1292, 1133, 'E', 'A', 'Mr.', 'AASHISH', '', 'CHOUDHARY', 1, 64, 6, 257, 924, '7415824346', 'aashishchoudhary.vspl@gmail.com', 'M', 'N', 'N', 78, '2021-04-13', NULL, '337091', NULL),
(1293, 1134, 'E', 'A', 'Mr.', 'MONU', '', 'VERMA', 1, 65, 6, 255, 584, '9301347081', 'monuverma.vspl@gmail.com', 'M', 'Y', 'N', 31, '2021-04-14', NULL, '607027', NULL),
(1294, 1135, 'E', 'A', 'Mr.', 'MADARAPU', '', 'KARTHEEK', 1, 65, 24, 239, 263, '9959771389', 'mkartheek.vspl@gmail.com', 'M', 'N', 'N', 155, '2021-04-15', NULL, '404991', NULL),
(1295, 1136, 'E', 'A', 'Mr.', 'GURMUKH ', 'SINGH', 'JOHAL', 1, 63, 6, 286, 731, '7898890923', 'gurmukhsingh.vspl@gmail.com', 'M', 'N', 'N', 288, '2021-04-15', NULL, '450018', NULL),
(1296, 1137, 'E', 'A', 'Mr.', 'ANIL', '', 'KUMAR', 1, 65, 6, 492, 4, '7018331203', 'anilkumar02.vspl@gmail.com', 'M', 'N', 'N', 3, '2021-04-16', NULL, '600007', NULL),
(1297, 1138, 'E', 'D', 'Mr.', 'SANDEEP', '', 'KUMAR', 1, 65, 6, 255, 4, '8581881576', 'sandeepkumar87.vspl@gmail.com', 'M', 'Y', 'N', 67, '2021-04-16', '2021-06-12', '631670', NULL),
(1298, 1139, 'E', 'A', 'Mr.', 'CHADUVU', '', 'SRISAILAM', 1, 61, 2, 307, 283, '9700402001', '', 'M', 'N', 'N', 7, '2021-04-16', NULL, '175092', NULL),
(1299, 1140, 'E', 'A', 'Mr.', 'AMOL', 'MAHADEV', 'PATIL', 1, 65, 6, 255, 718, '7259185891', 'amolmpatil.vspl@gmail.com', 'M', 'N', 'N', 178, '2021-04-23', NULL, '500026', NULL),
(1300, 1141, 'E', 'A', 'Ms.', 'SAPNA', '', 'MOHANTY', 1, 63, 5, 127, 52, '8305960724', '', 'F', 'N', 'N', 14, '2021-05-03', NULL, '213994', NULL),
(1301, 1142, 'E', 'A', 'Mr.', 'PEEREDDY', 'SHIVANAND', 'REDDY', 1, 65, 6, 492, 597, '7775905813', 'shivanandreddy.vspl@gmail.com', 'M', 'N', 'N', 106, '2021-05-03', NULL, '600007', NULL),
(1302, 1143, 'E', 'A', 'Mr.', 'KIRAN', '', 'PARAMANIK', 1, 63, 6, 286, 916, '8927835085', 'kiranparamanik.vspl@gmail.com', 'M', 'N', 'N', 243, '2021-05-03', NULL, '365003', NULL),
(1303, 1144, 'E', 'A', 'Mr.', 'MANOJKUMAR', 'GENDLAL', 'BAGHELE', 1, 65, 6, 255, 14, '9545851725', 'manojbaghele.vspl@gmail.com', 'M', 'Y', 'N', 140, '2021-05-03', NULL, '650016', NULL),
(1304, 1145, 'E', 'A', 'Mr.', 'PAVAN', 'KUMAR', 'BHAWSAR', 1, 65, 6, 255, 14, '9165614773', 'pavankbhawsar.vspl@gmail.com', 'M', 'N', 'N', 191, '2021-05-05', NULL, '485067', NULL),
(1305, 1146, 'E', 'A', 'Mr.', 'TARUN', 'KUMAR', 'SAHU', 1, 63, 9, 88, 169, '9907790415', 'tarunkumarsahu.vspl@gmail.com', 'M', 'N', 'N', 1, '2021-05-17', NULL, '278155', NULL),
(1306, 1147, 'E', 'A', 'Mr.', 'SASWATA', '', 'MONDAL', 1, 63, 6, 286, 261, '9348342859', 'saswatamondal.vspl@gmail.com', 'M', 'N', 'N', 108, '2021-05-17', NULL, '365003', NULL),
(1307, 1148, 'E', 'A', 'Mr.', 'VINAY', '', 'VIJ', 1, 65, 8, 83, 109, '8871884375', 'vinayvij.vspl@gmail.com', 'M', 'N', 'N', 1, '2021-05-24', NULL, '387155', NULL),
(1308, 10002, 'E', 'A', 'Mr.', 'MANISH', '', 'KARKUN', 3, 34, 20, 616, 0, '9685436177', 'manish.karkun@vnrseeds.com', 'M', 'N', 'N', 102, '2009-06-02', NULL, '0', NULL),
(1309, 1149, 'E', 'A', 'Mr.', 'YOGESH', '', 'KUMAR', 1, 63, 25, 617, 491, '9131539097', 'yogeshkumar.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-06-01', NULL, '191177', NULL),
(1310, 1150, 'E', 'A', 'Mr.', 'ASHISH', 'PRASAD', 'DUBEY', 1, 63, 5, 59, 1256, '7828574688', 'ashishprasad.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-06-01', NULL, '189936', NULL),
(1311, 1151, 'E', 'A', 'Mr.', 'ANKIT', '', 'SINGH', 1, 65, 5, 50, 52, '7000018429', 'ankitsinghplant.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-06-01', NULL, '222265', NULL),
(1312, 1152, 'E', 'A', 'Mr.', 'KETAN', '', 'DWIVEDI', 1, 64, 8, 193, 109, '7077217687', 'ketandwivedi.vspl@gmail.com', 'M', 'N', 'N', 1, '2021-06-05', NULL, '265765', NULL),
(1313, 1153, 'E', 'A', 'Ms.', 'DIMPLE', '', 'WADHWANI', 1, 63, 1, 301, 182, '7987221933', 'dimple.wadhwani@vnrseeds.com', 'F', 'N', 'N', 1, '2021-06-09', NULL, '222265', NULL),
(1314, 10003, 'E', 'A', 'Mr.', 'KUSH', 'DUTT', 'RAWAT', 3, 33, 21, 619, 260, '9981995345', 'kush.dutt@vnrseeds.in', 'M', 'N', 'N', 406, '2013-07-01', NULL, '0', NULL),
(1315, 1155, 'E', 'A', 'Ms.', 'SHIKHA', '', '.', 1, 65, 1, 198, 142, '6265575386', 'shikha.khadka@vnrseeds.com', 'F', 'N', 'N', 1, '2021-06-16', NULL, '414698', NULL),
(1316, 1156, 'E', 'A', 'Mr.', 'MALIS', 'CHANDRA SHEKAR', 'REDDY', 1, 65, 6, 492, 220, '9553070317', 'mchandrashekhar.vspl@gmail.com', 'M', 'N', 'N', 53, '2021-06-16', NULL, '600007', NULL),
(1317, 1154, 'E', 'A', 'Mr.', 'SANJEEV', 'KUMAR', 'GUPTA', 1, 66, 5, 48, 52, '7499231301', 'sanjeevgupta.vspl@gmail.com', 'M', 'Y', 'N', 405, '2021-06-15', NULL, '600007', NULL),
(1318, 1157, 'E', 'A', 'Mr.', 'PRADEEP', 'KUMAR', 'KUSHWAHA', 1, 64, 6, 257, 924, '7434846203', 'pradeepkushwaha.vspl@gmail.com', 'M', 'Y', 'N', 167, '2021-06-16', NULL, '479348', NULL),
(1320, 1158, 'E', 'A', 'Mr.', 'HARSHAL', 'KEVALSING', 'PATIL', 1, 64, 6, 257, 913, '8668235958', 'harshalkevalsingpatil.vspl@gmail.com', 'M', 'Y', 'N', 166, '2021-06-26', NULL, '357515', NULL),
(1321, 1159, 'E', 'A', 'Dr.', 'INJEY', '', 'SUDHARSHAN', 1, 68, 2, 5, 7, '8121491790', 'injeysudarshan.vspl@gmail.com', 'M', 'Y', 'Y', 7, '2021-07-01', NULL, '800006', NULL),
(1322, 1160, 'E', 'A', 'Ms.', 'SAKSHI', '', 'MISHRA', 1, 64, 24, 237, 543, '7999051583', 'sakshimishra.vspl@gmail.com', 'F', 'N', 'N', 14, '2021-07-03', NULL, '303803', NULL),
(1323, 1161, 'E', 'A', 'Mr.', 'YOGENDRA', '', 'MAHILANGE', 1, 64, 24, 237, 382, '6263181521', 'yogendramahilange.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-07-03', NULL, '303803', NULL),
(1324, 1162, 'E', 'A', 'Mr.', 'CHUNNI', 'LAL', 'PATEL', 1, 64, 24, 237, 382, '9131880195', 'chunnilalpatel.vspl@gmail.com', 'M', 'N', 'N', 14, '2021-07-03', NULL, '303803', NULL),
(1325, 1163, 'E', 'A', 'Mr.', 'LEELESH ', '', 'SHARMA', 1, 66, 6, 68, 924, '8120264280', 'leeleshsharma.vspl@gmail.com', 'M', 'Y', 'N', 85, '2021-07-03', NULL, '650016', NULL),
(1326, 1164, 'E', 'A', 'Dr.', 'MANOJ ', '', 'N V', 1, 68, 2, 5, 89, '9449069273', 'manojnv.vspl@gmail.com', 'M', 'Y', 'Y', 7, '2021-07-12', NULL, '720004', NULL),
(1327, 1165, 'E', 'A', 'Dr.', 'ARUN', 'HANUMANTRAO', 'PATIL', 1, 67, 2, 439, 601, '8982152463', 'arunpatil.vspl@gmail.com', 'M', 'Y', 'Y', 1, '2021-07-12', NULL, '600007', NULL),
(1328, 1166, 'E', 'A', 'Mr.', 'SURYA', 'KANTA', 'DAS', 1, 63, 6, 286, 375, '7978288900', 'suryakantadas.vspl@gmail.com', 'M', 'N', 'N', 121, '2021-07-15', NULL, '365003', NULL),
(1329, 1167, 'E', 'A', 'Mr.', 'DASARATHI', '', 'SAHOO', 1, 63, 6, 286, 375, '8249867424', 'dasarathisahoo.vspl@gmail.com', 'M', 'N', 'N', 189, '2021-07-15', NULL, '450018', NULL),
(1330, 1168, 'E', 'A', 'Mr.', 'ANKIT ', '', 'PATIDAR', 1, 64, 6, 257, 34, '8085737284', 'ankitpatidar.vspl@gmail.com', 'M', 'Y', 'N', 211, '2021-07-16', NULL, '356975', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_emp_position_codes`
--

CREATE TABLE `master_emp_position_codes` (
  `EmPosCodeID` int(11) NOT NULL,
  `EmpCode` int(11) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `GradeId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `DesigId` int(11) NOT NULL DEFAULT 0,
  `PositionCode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PositionSequence` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_grade`
--

CREATE TABLE `master_grade` (
  `GradeId` int(11) NOT NULL,
  `GradeValue` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CompanyId` int(11) NOT NULL,
  `GradeStatus` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'A-active,D-deactive,De-delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_grade`
--

INSERT INTO `master_grade` (`GradeId`, `GradeValue`, `CompanyId`, `GradeStatus`) VALUES
(1, '1', 1, 'A'),
(2, '2', 1, 'A'),
(3, '3', 1, 'A'),
(4, '4', 1, 'A'),
(5, '5', 1, 'A'),
(6, '6', 1, 'A'),
(7, '7', 1, 'A'),
(8, '8', 1, 'A'),
(9, '9', 1, 'A'),
(10, '10', 1, 'A'),
(11, '11', 1, 'A'),
(12, '12', 1, 'A'),
(13, '13', 1, 'A'),
(14, '14', 1, 'A'),
(15, '0', 1, 'A'),
(16, '1', 2, 'A'),
(17, '2', 2, 'A'),
(18, '3', 2, 'A'),
(19, '4', 2, 'A'),
(20, '5', 2, 'A'),
(21, '6', 2, 'A'),
(22, '7', 2, 'A'),
(23, '8', 2, 'A'),
(24, '9', 2, 'A'),
(25, '10', 2, 'A'),
(26, '11', 2, 'A'),
(27, '12', 2, 'A'),
(28, '13', 2, 'A'),
(29, '14', 2, 'A'),
(30, '0', 2, 'A'),
(31, '1', 3, 'A'),
(32, '2', 3, 'A'),
(33, '3', 3, 'A'),
(34, '4', 3, 'A'),
(35, '5', 3, 'A'),
(36, '6', 3, 'A'),
(37, '7', 3, 'A'),
(38, '8', 3, 'A'),
(39, '9', 3, 'A'),
(40, '10', 3, 'A'),
(41, '11', 3, 'A'),
(42, '12', 3, 'A'),
(43, '13', 3, 'A'),
(44, '14', 3, 'A'),
(45, '0', 3, 'A'),
(46, '1', 4, 'A'),
(47, '2', 4, 'A'),
(48, '3', 4, 'A'),
(49, '4', 4, 'A'),
(50, '5', 4, 'A'),
(51, '6', 4, 'A'),
(52, '7', 4, 'A'),
(53, '8', 4, 'A'),
(54, '9', 4, 'A'),
(55, '10', 4, 'A'),
(56, '11', 4, 'A'),
(57, '12', 4, 'A'),
(58, '13', 4, 'A'),
(59, '14', 4, 'A'),
(60, '0', 4, 'A'),
(61, 'S1', 1, 'A'),
(62, 'S2', 1, 'A'),
(63, 'J1', 1, 'A'),
(64, 'J2', 1, 'A'),
(65, 'J3', 1, 'A'),
(66, 'J4', 1, 'A'),
(67, 'M1', 1, 'A'),
(68, 'M2', 1, 'A'),
(69, 'M3', 1, 'A'),
(70, 'M4', 1, 'A'),
(71, 'M5', 1, 'A'),
(72, 'L1', 1, 'A'),
(73, 'L2', 1, 'A'),
(74, 'L3', 1, 'A'),
(75, 'L4', 1, 'A'),
(76, 'L5', 1, 'A'),
(77, 'MG', 1, 'A'),
(78, 'S1', 3, 'A'),
(79, 'J4', 4, 'A'),
(80, '1', 4, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_headquater`
--

CREATE TABLE `master_headquater` (
  `HqId` int(11) NOT NULL,
  `HqName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StateId` int(11) NOT NULL,
  `CompanyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_headquater`
--

INSERT INTO `master_headquater` (`HqId`, `HqName`, `StateId`, `CompanyId`) VALUES
(1, 'RAIPUR', 5, 1),
(2, 'KANPUR', 34, 1),
(3, 'MUZAFFARPUR', 4, 1),
(4, 'VARANASI', 36, 1),
(5, 'PATNA', 4, 1),
(6, 'CHENNAI', 26, 1),
(7, 'HYDERABAD', 30, 1),
(8, 'KURUKSHETRA', 10, 1),
(9, 'KOHADIYA', 5, 1),
(10, 'RANCHI', 6, 1),
(12, 'ALIGARH', 35, 1),
(13, 'PANAGARH', 23, 1),
(14, 'DEORJHAL', 5, 1),
(15, 'GOMCHI', 5, 1),
(17, 'KADAPA', 30, 1),
(18, 'MIRZAPUR', 36, 1),
(19, 'GHAZIPUR', 36, 1),
(20, 'BARGARH', 21, 1),
(21, 'INDORE', 15, 1),
(22, 'KARIMNAGAR', 30, 1),
(23, 'MORADABAD', 35, 1),
(24, 'PURNIA', 4, 1),
(25, 'DHAMNOD', 15, 1),
(26, 'JALANDHAR', 22, 1),
(27, 'HIMMATNAGAR', 9, 1),
(28, 'NAGPUR', 32, 1),
(29, 'MEDCHAL', 1, 1),
(30, 'BAHARAICH', 34, 1),
(31, 'DHAMTARI', 5, 1),
(32, 'GUNTUR', 1, 1),
(33, 'GAYA', 4, 1),
(34, 'BHUBANESWAR', 21, 1),
(35, 'MAINPURI', 35, 1),
(36, 'PRATAPGARH', 34, 1),
(37, 'JAIPUR', 24, 1),
(38, 'RATLAM', 15, 1),
(39, 'GORAKHPUR', 36, 1),
(40, 'PALANI', 26, 1),
(41, 'MALERKOTLA', 22, 1),
(42, 'VADODARA', 9, 1),
(43, 'LADWA', 22, 1),
(44, 'FATEHPUR', 29, 1),
(45, 'FAIZABAD', 34, 1),
(46, 'NASHIK', 33, 1),
(47, 'AGRA', 35, 1),
(48, 'PARCHETTI', 5, 1),
(49, 'SORUMSINGHI', 5, 1),
(50, 'DIBRUGARH', 3, 1),
(51, 'RAJKOT', 9, 1),
(52, 'MANSA', 9, 1),
(53, 'ANANTPUR', 30, 1),
(54, 'GULBARGA', 1, 1),
(55, 'AMBALA', 22, 1),
(56, 'DALTONGANJ', 6, 1),
(57, 'AKOLA', 32, 1),
(58, 'SATARA', 33, 1),
(59, 'HAZARIBAGH', 6, 1),
(60, 'ANAND', 9, 1),
(61, 'AURANGABAD', 33, 1),
(62, 'TITLAGARH', 21, 1),
(63, 'JAGDALPUR', 5, 1),
(64, 'RAJNANDGAON', 5, 1),
(65, 'SILLIGURI', 23, 1),
(66, 'AMBIKAPUR', 5, 1),
(67, 'CHAPRA', 4, 1),
(68, 'WARANGAL', 30, 1),
(69, 'MADANAPALLE', 30, 1),
(70, 'ALLAHABAD', 36, 1),
(71, 'DHARAMPUR', 9, 1),
(72, 'RAJAHMUNDRY', 1, 1),
(73, 'DEOGHAR', 6, 1),
(74, 'KOTA', 24, 1),
(75, 'DHABA', 5, 1),
(76, 'JOYPUR', 21, 1),
(77, 'HUBLI', 13, 1),
(78, 'SANAWAD', 15, 1),
(79, 'DHULE', 33, 1),
(80, 'BAIKUNTHPUR', 5, 1),
(81, 'BAREILLY', 35, 1),
(82, 'BHANDARA', 32, 1),
(83, 'SAWAIMADHOPUR', 24, 1),
(84, 'DEULGAON RAJA', 33, 1),
(85, 'SATNA', 15, 1),
(86, 'MYSORE', 13, 1),
(87, 'BILASPUR', 5, 1),
(88, 'BALAGHAT', 15, 1),
(89, 'RANAGHAT', 23, 1),
(90, 'BAYAD', 9, 1),
(91, 'BHATAPARA', 5, 1),
(92, 'RAIPUR', 5, 2),
(93, 'NARAYANGAON', 33, 1),
(94, 'RANEBENNUR', 13, 1),
(95, 'LUCKNOW', 34, 1),
(96, 'SANGLI', 33, 1),
(97, 'BHAGALPUR', 4, 1),
(98, 'PANIPAT', 10, 1),
(99, 'NANDYAL', 1, 1),
(101, 'SONIPAT', 10, 1),
(102, 'RAIPUR', 5, 3),
(103, 'Gomchi', 5, 3),
(104, 'Sholapur', 16, 3),
(105, 'SHADNAGAR', 1, 1),
(106, 'VIJAYAWADA', 1, 1),
(107, 'SAGAR', 15, 1),
(109, 'RAMGARH', 6, 1),
(110, 'GUMLA', 6, 1),
(111, 'Vadodara', 9, 3),
(112, 'KOLHAPUR', 33, 1),
(113, 'UDAIPUR', 24, 1),
(114, 'TAUNK', 24, 1),
(115, 'HASSAN', 13, 1),
(116, 'GODHRA', 9, 1),
(117, 'GAJWEL', 1, 1),
(118, 'MAHASAMUND', 5, 1),
(119, 'AMRITSAR', 22, 1),
(120, 'BASTI', 36, 1),
(121, 'BERHAMPUR', 21, 1),
(122, 'KARNAL', 10, 1),
(123, 'GONDAL', 9, 1),
(124, 'VIJAYNAGRAM', 1, 1),
(126, 'JADCHERLA', 30, 1),
(127, 'VILLUPURAM', 26, 1),
(128, 'ALWAR', 24, 1),
(129, 'KURNOOL', 30, 1),
(130, 'ELURU', 1, 1),
(131, 'SORUM', 5, 1),
(132, 'GANDHINAGAR', 9, 1),
(133, 'PUNE', 33, 1),
(134, 'CHITTORGARH', 24, 1),
(135, 'TRICHY', 26, 1),
(137, 'MADHAIPURA                                       ', 4, 1),
(139, 'SITAPUR', 5, 1),
(140, 'GONDIA', 32, 1),
(141, 'DAUSA', 24, 1),
(142, 'CUTTACK', 21, 1),
(143, 'PURULIA', 23, 1),
(144, 'SULTANPUR', 29, 1),
(145, 'AZAMGARH', 36, 1),
(146, 'KAUSAMBI', 29, 1),
(147, 'RAIBAREILLY', 34, 1),
(148, 'JHANSI', 34, 1),
(149, 'LUDHIANA', 22, 1),
(151, 'JAMMU', 12, 1),
(153, 'DHARMAPURI', 26, 1),
(154, 'PARBHANI', 32, 1),
(155, 'BANDAMAILARAM', 1, 1),
(156, 'YAVATMAL', 32, 1),
(157, 'BIJNOR', 35, 1),
(158, 'PRODDATUR', 1, 1),
(159, 'DUAL', 29, 1),
(160, 'YAMUNA NAGAR', 10, 1),
(161, 'SAMASTIPUR', 4, 1),
(162, 'BHADRAK', 21, 1),
(163, 'HUMNABAD', 13, 1),
(164, 'HOSHIARPUR', 22, 1),
(165, 'MAHARAJGANJ', 29, 1),
(166, 'JALGAON', 33, 1),
(167, 'SHIVPURI', 15, 1),
(168, 'SURAT', 9, 1),
(169, 'JUNAGADH', 9, 1),
(170, 'SITAPUR', 34, 1),
(171, 'MEERUT', 35, 1),
(172, 'JABALPUR', 15, 1),
(173, 'ROHTAK', 10, 1),
(174, 'MUZAFFARNAGAR', 35, 1),
(175, 'SHIKOHABAD', 35, 1),
(176, 'BIHARSHARIF', 4, 1),
(177, 'GARHWA', 6, 1),
(178, 'DAVANGERE', 13, 1),
(179, 'KOLKATA', 23, 1),
(180, 'HUMNABAD', 30, 1),
(181, 'CHHINDWADA', 15, 1),
(182, 'HAPUR', 35, 1),
(183, 'SIDDHARTHNAGAR', 34, 1),
(184, 'SIDDHARTHNAGAR', 34, 1),
(185, 'URANGA', 5, 1),
(186, 'MUMBAI', 16, 1),
(187, 'JAJAPUR', 21, 1),
(188, 'BALRAMPUR', 34, 1),
(189, 'SUNDERGARH', 21, 1),
(190, 'BHILWARA', 24, 1),
(191, 'SHAHDOL', 15, 1),
(192, 'TIRUNELVELI', 26, 1),
(193, 'CHARAMA', 5, 1),
(194, 'RAMANUJGANJ', 5, 1),
(195, 'SHAHDOL', 15, 1),
(196, 'MAINPAT', 5, 1),
(197, 'GUWAHATI', 3, 1),
(198, 'SHIKOHABAD', 35, 1),
(199, 'BIHAR SHARIF', 4, 1),
(200, 'THENI', 26, 1),
(201, 'DEWAS', 15, 1),
(202, 'UMARKOT', 21, 1),
(203, 'KAWARDHA', 5, 1),
(204, 'BENGALURU', 13, 1),
(205, 'HARDOI', 34, 1),
(206, 'GHAZIABAD', 35, 1),
(207, 'FATEHABAD', 10, 1),
(208, 'PATHALGAON', 5, 1),
(209, 'AURAIYA', 34, 1),
(210, 'NANDED', 32, 1),
(211, 'VALSAD', 9, 1),
(212, 'Mandya', 13, 1),
(213, 'MANDYA', 1, 1),
(214, 'BAHARAMPUR', 23, 1),
(215, 'CHIKBELLAPUR', 13, 1),
(216, 'HAVERI', 13, 1),
(217, 'BELGAUM', 13, 1),
(218, 'KHAMMAM', 1, 1),
(219, 'BELLARY', 13, 1),
(220, 'GULBARGA', 13, 1),
(221, 'BIJAPUR', 13, 1),
(222, 'BABAI', 15, 1),
(223, 'LOHARDAGA', 6, 1),
(224, 'NIZAMABAD', 30, 1),
(225, 'NAWARANGPUR', 21, 1),
(226, 'VYARA', 9, 1),
(227, 'VYARA', 1, 1),
(228, 'TONK', 24, 1),
(229, 'SATHUPALLI', 30, 1),
(230, 'VISAKHAPATNAM', 1, 1),
(231, 'SOLAPUR', 33, 1),
(232, 'GIRIDIH', 6, 1),
(233, 'PERAMBALUR', 26, 1),
(234, 'DINDIGUL', 26, 1),
(235, 'MANDLA', 15, 1),
(236, 'SURYAPET', 30, 1),
(237, 'Jagdalpur', 5, 3),
(238, 'BHANUPRATAPPUR', 5, 1),
(239, 'DEORIA', 36, 1),
(240, 'ROBERTSGANJ', 36, 1),
(241, 'RUPAIDIHA', 29, 1),
(242, 'JALESWAR', 21, 1),
(243, 'BARPETA', 3, 1),
(244, 'BALASORE ', 21, 1),
(245, 'AHMEDNAGAR', 33, 1),
(246, 'COIMBATORE', 26, 1),
(247, 'BARDHAMAN', 23, 1),
(248, 'MAHBUBNAGAR', 30, 1),
(249, 'GARIABAND', 5, 1),
(250, 'BHAWANIPATNA', 21, 1),
(251, 'DURG', 5, 1),
(252, 'HOSHANGABAD', 15, 1),
(253, 'BUNDU', 6, 1),
(254, 'BELAGAVI', 13, 1),
(255, 'Khandwa', 15, 3),
(256, 'BERHAMPORE', 23, 1),
(257, 'MATHURA', 35, 1),
(258, 'HATHRAS', 29, 1),
(259, 'JAMSHEDPUR', 6, 1),
(260, 'KONDAGAON', 5, 1),
(261, 'BASTAR', 5, 1),
(262, 'BALRAMPUR', 5, 1),
(263, 'PURI', 21, 1),
(264, 'KALAHANDI', 21, 1),
(265, 'GUNDARDEHI', 5, 1),
(266, 'KURUD', 5, 1),
(267, 'JOGULAMBA GADWAL', 30, 1),
(268, 'KATIHAR', 4, 1),
(269, 'BUNDI', 24, 1),
(270, 'MAHISAGAR', 9, 1),
(271, ' JAJAPUR', 21, 1),
(272, 'KANTABANJI', 21, 1),
(273, 'RAIPUR', 5, 4),
(274, 'DEORJHAL', 5, 4),
(275, 'BANDAMAILARAM', 30, 4),
(276, 'HYDERABAD', 30, 4),
(278, 'KARIMNAGAR', 30, 4),
(279, 'RANCHI', 6, 4),
(280, 'PATNA', 4, 4),
(281, 'MAHASAMUND', 5, 4),
(283, 'CHENNAI', 26, 4),
(284, 'SURATGARH', 24, 1),
(285, 'ONGOLE', 1, 1),
(286, 'SAKTI', 5, 1),
(287, 'GWALIOR', 15, 1),
(288, 'JAUNPUR', 36, 1),
(289, 'BALLIA', 36, 1),
(290, 'REWA', 15, 1),
(291, 'JAMUI', 4, 1),
(292, 'HAJIPUR', 4, 1),
(293, 'KEONJHAR', 21, 1),
(294, 'BHADRACHALAM', 1, 1),
(295, 'SONBHADRA', 29, 1),
(296, 'RAIGANJ', 23, 1),
(297, 'MORENA', 15, 1),
(298, 'ARMOOR', 30, 1),
(299, 'HOOGLY', 23, 1),
(300, 'WAIDHAN', 15, 1),
(301, 'NAGAON', 3, 1),
(302, 'JORHAT', 3, 1),
(303, 'AGARATALA', 27, 1),
(304, 'BARPETA - 2', 3, 1),
(305, 'AMALAPURAM', 1, 1),
(306, 'MYDUKUR', 1, 1),
(307, 'ARANG', 5, 4),
(308, 'KHARIAR ROAD', 5, 4),
(309, 'Jaleshwar', 21, 4),
(310, 'Dhamtari', 5, 4),
(311, 'BHUBANESHWAR', 21, 4),
(312, 'SIRPUR', 5, 4),
(313, 'PURI', 21, 4),
(314, 'PITHORA', 5, 4),
(315, 'FINGESHWAR', 21, 4),
(316, 'NARHARPUR', 5, 4),
(317, 'LATABOT', 5, 4),
(318, 'KURNOOL', 1, 4),
(319, 'KANTABANJI', 21, 4),
(320, 'ELURU', 1, 4),
(321, 'BURDWAN', 23, 4),
(322, 'DUDAWA', 5, 4),
(323, 'KALAHANDI', 21, 4),
(324, 'SANOUD', 5, 4),
(325, 'JOGULAMBA GADWAL', 30, 4),
(326, 'SURHI', 5, 4),
(327, 'BHADRAK', 21, 4),
(328, 'SANGALI', 5, 4),
(329, 'SAMBALPUR', 5, 4),
(330, 'KUKREL', 5, 4),
(331, 'CHARAMA', 5, 4),
(332, 'DUGALI', 5, 4),
(333, 'MEGHA', 5, 4),
(334, 'SALONI', 5, 4),
(335, 'ARJUNDA', 5, 4),
(336, 'KANDEL', 5, 4),
(337, 'JUNAGARH', 5, 4),
(339, 'KORRA', 5, 4),
(340, 'KORRA', 5, 4),
(341, 'MADAIBHATA', 5, 4),
(342, 'BELOUDI', 5, 4),
(343, 'SANKRA', 5, 4),
(344, 'BAGBAHARA', 5, 4),
(345, 'CHHURA', 5, 4),
(346, 'NANDYAL', 1, 4),
(347, 'MANTHANI', 30, 4),
(348, 'TEKUMATLA', 30, 4),
(349, 'MAGARLOAD', 5, 4),
(350, 'GADWAL', 30, 4),
(352, 'COOCH BEHAR', 3, 1),
(353, 'YEOLA', 33, 1),
(354, 'SILCHAR', 3, 1),
(355, 'JEYPORE', 21, 1),
(356, 'PRAYAGRAJ', 29, 1),
(357, 'SEONI', 15, 1),
(358, 'KANKER', 5, 1),
(359, 'PANCHMAHAL', 9, 1),
(360, 'RAJKOT', 9, 1),
(361, 'Kohadiya', 5, 3),
(362, 'PEDDAPALLI', 30, 1),
(363, 'JIND', 10, 1),
(364, 'BHAWANIPATNA', 21, 1),
(365, 'RANEBENNUR', 13, 4),
(366, 'GOP', 21, 4),
(367, 'BAYAD', 9, 4),
(368, 'BASTA', 21, 4),
(369, 'KAMARDA', 21, 4),
(370, 'BALIAPAL', 21, 4),
(371, 'KALVASRIRAMPUR', 30, 4),
(372, 'VAVILALA', 30, 4),
(373, 'MANGAPETA', 30, 4),
(374, 'CHOPPANDANDI', 30, 4),
(375, 'PARVATHAGIRI', 30, 4),
(376, 'BATREL', 5, 4),
(377, 'ARKAR', 5, 4),
(378, 'BODRA', 5, 4),
(379, 'BODRA', 5, 4),
(380, 'BOTHLI', 5, 4),
(381, 'KAMALAPUR', 30, 4),
(382, 'NARSAMPET', 30, 4),
(383, 'SIDDIPET', 30, 4),
(384, 'SATHUPALLI', 30, 4),
(385, 'DHARMARAM', 30, 4),
(386, 'DHARUR', 30, 4),
(387, 'SIRIVELLA', 1, 4),
(388, 'SHADNAGAR', 30, 4),
(389, 'MANTHANI', 30, 4),
(390, 'WARANGAL', 30, 4),
(391, 'MADAMSILLI', 5, 4),
(392, 'LONAR', 16, 1),
(393, 'BRAHMAPUR', 21, 1),
(394, 'Bastar', 5, 3),
(395, 'CHOMU', 24, 1),
(396, 'JAIPUR', 24, 4),
(397, 'BASTAR', 5, 4),
(398, 'JAGDALPUR', 5, 4),
(399, 'NIZAMABAD', 30, 4),
(400, 'ERODE', 26, 4),
(401, 'SAMBALPUR', 21, 1),
(403, 'BERLA', 5, 1),
(404, 'NABARANGPUR', 21, 1),
(405, 'BEMETARA', 5, 1),
(406, 'Kondagaon', 5, 3),
(407, 'Boriya', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_institute`
--

CREATE TABLE `master_institute` (
  `InstituteId` int(11) NOT NULL,
  `InstituteName` varchar(300) NOT NULL,
  `InstituteCode` varchar(100) NOT NULL,
  `StateId` int(5) NOT NULL,
  `DistrictId` int(5) NOT NULL,
  `Category` varchar(20) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Status` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_institute`
--

INSERT INTO `master_institute` (`InstituteId`, `InstituteName`, `InstituteCode`, `StateId`, `DistrictId`, `Category`, `Type`, `Status`) VALUES
(1, 'Rungta College of Engineering and Technology', 'RCET', 7, 112, 'Private', 'Non-Agri', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_location`
--

CREATE TABLE `master_location` (
  `LocationId` int(11) NOT NULL,
  `Location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LocationCode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LocationAddress` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CountryId` int(11) NOT NULL,
  `StateId` int(11) NOT NULL,
  `DistrictId` int(11) NOT NULL,
  `CityId` int(11) NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_pages`
--

CREATE TABLE `master_pages` (
  `pid` int(11) NOT NULL,
  `pageName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pageParent` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pageSequence` int(11) NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `pageFor` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_resumesource`
--

CREATE TABLE `master_resumesource` (
  `ResumeSouId` int(11) NOT NULL,
  `ResumeSource` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Editable` int(11) NOT NULL DEFAULT 1,
  `Status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_resumesource`
--

INSERT INTO `master_resumesource` (`ResumeSouId`, `ResumeSource`, `Editable`, `Status`) VALUES
(1, 'Indeed.com', 1, 'A'),
(2, 'Naukri.com', 1, 'A'),
(3, 'College / Campus', 0, 'A'),
(4, 'Direct WalkIn', 0, 'A'),
(5, 'VNR Site', 0, 'A'),
(6, 'LinkedIn', 1, 'A'),
(7, 'Consultancy', 1, 'A'),
(8, 'Employee Reference', 1, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_specialization`
--

CREATE TABLE `master_specialization` (
  `SpId` int(11) NOT NULL,
  `EducationId` int(11) NOT NULL,
  `Specialization` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_specialization`
--

INSERT INTO `master_specialization` (`SpId`, `EducationId`, `Specialization`, `Status`) VALUES
(1, 2, 'Computer Application', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `master_state`
--

CREATE TABLE `master_state` (
  `StateId` int(11) NOT NULL,
  `StateName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StateCode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Country` int(11) DEFAULT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedTime` datetime NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `IsDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_state`
--

INSERT INTO `master_state` (`StateId`, `StateName`, `StateCode`, `Country`, `Status`, `CreatedTime`, `CreatedBy`, `LastUpdated`, `UpdatedBy`, `IsDeleted`) VALUES
(1, 'ANDHRA PRADESH', 'AP', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(2, 'ARUNACHAL PRADESH', 'AR', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(3, 'ASSAM', 'AS', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(4, 'BIHAR', 'BR', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(5, 'CHHATTISGARH', 'CG', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(6, 'JHARKHAND', 'JH', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(7, 'DELHI', 'DL', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(8, 'GOA', 'GA', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(9, 'GUJARAT', 'GJ', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(10, 'HARYANA', 'HR', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(11, 'HIMACHAL PRADESH', 'HP', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(12, 'JAMMU & KASHMIR', 'JK', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(13, 'KARNATAKA', 'KA', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(14, 'KERALA', 'KL', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(15, 'MADHYA PRADESH', 'MP', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(16, 'MAHARASHTRA', 'MH', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(17, 'MANIPUR', 'MN', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(18, 'MEGHALAYA', 'ML', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(19, 'MIZORAM', 'MZ', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(20, 'NAGALAND', 'NL', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(21, 'ODISHA', 'OR', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(22, 'PUNJAB', 'PB', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(23, 'WEST BENGAL', 'WB', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(24, 'RAJASTHAN', 'RJ', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(25, 'SIKKIM', 'SK', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(26, 'TAMIL NADU', 'TN', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(27, 'TRIPURA', 'TR', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(28, 'UTTARAKHAND', 'UT', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(29, 'UTTAR PRADESH', 'UP', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(30, 'TELANGANA', 'TG', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(31, 'PUDUCHERRY ', 'PY', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(32, 'VIDARBHA', 'VDH', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(33, 'WESTERN MAHARASTRA', 'WMH', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(34, 'CENTRAL UTTAR PRADESH', 'CUP', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(35, 'WESTERN UTTAR PRADESH', 'WUP', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(36, 'EASTERN UTTAR PRADESH', 'EUP', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(37, 'NORTH KARNATAKA', 'NKTK', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0),
(38, 'SOUTH KARNATAKA', 'SKTK', 1, 'A', '2021-07-22 22:33:19', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_07_21_225044_create_log_activity_table', 1),
(2, '2021_07_22_174004_creat_logbook_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `offerletterbasic`
--

CREATE TABLE `offerletterbasic` (
  `OfLeId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `Company` int(11) NOT NULL,
  `Grade` int(11) NOT NULL,
  `Department` int(11) NOT NULL,
  `Designation` int(11) NOT NULL,
  `TempS` tinyint(4) NOT NULL DEFAULT 0,
  `T_StateHq` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Temporary',
  `T_LocationHq` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Temporary',
  `TempM` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FixedS` tinyint(4) NOT NULL DEFAULT 0,
  `F_StateHq` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Fixed',
  `F_LocationHq` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Fixed',
  `Functional_R` tinyint(4) NOT NULL DEFAULT 0,
  `Functional_Dpt` int(11) NOT NULL COMMENT 'Functional Reporting Department',
  `F_ReportingManager` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Functional | EmployeeID',
  `Admins_R` tinyint(4) NOT NULL DEFAULT 0,
  `Admins_Dpt` int(11) NOT NULL COMMENT 'Administrative Reporting Department',
  `A_ReportingManager` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Administrative | EmployeeID',
  `CTC` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ServiceCondition` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrientationPeriod` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Stipend` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AFT_Grade` int(11) NOT NULL COMMENT 'After Training Grade',
  `AFT_Designation` int(11) NOT NULL COMMENT 'After Training Designation',
  `ServiceBond` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ServiceBondYears` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ServiceBondRefund` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PreMedicalCheckUp` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Remarks` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OfferLetter` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `CompDetails` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `EligDetails` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OfferLtrGen` tinyint(4) NOT NULL DEFAULT 0,
  `OfferLetterSent` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JoiningFormSent` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Answer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RejReason` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Reopen` tinyint(4) NOT NULL DEFAULT 0,
  `SendReview` tinyint(4) NOT NULL DEFAULT 0,
  `ReviewerMail` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReviewStatus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ReviewRejReason` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SendForRefChk` tinyint(4) NOT NULL DEFAULT 0,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_permissions`
--

CREATE TABLE `page_permissions` (
  `upid` int(11) NOT NULL,
  `uId` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userTypeId` int(11) NOT NULL,
  `pid` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sts` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `previous_screening`
--

CREATE TABLE `previous_screening` (
  `PSCId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `ReSentForScreen` date NOT NULL,
  `ScrCmp` int(11) NOT NULL,
  `ScrDpt` int(11) NOT NULL,
  `ScreeningBy` int(11) NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `processdatatoess`
--

CREATE TABLE `processdatatoess` (
  `Id` int(11) NOT NULL,
  `JCId` int(11) NOT NULL,
  `PersonalData` tinyint(4) NOT NULL DEFAULT 0,
  `AddressData` tinyint(4) NOT NULL DEFAULT 0,
  `FamilyData` tinyint(4) NOT NULL DEFAULT 0,
  `EducationalData` tinyint(4) NOT NULL DEFAULT 0,
  `LanguageData` tinyint(4) NOT NULL DEFAULT 0,
  `PreOrgData` tinyint(4) NOT NULL DEFAULT 0,
  `VnrData` tinyint(4) NOT NULL DEFAULT 0,
  `PFData` tinyint(4) NOT NULL DEFAULT 0,
  `WorkExpData` tinyint(4) NOT NULL DEFAULT 0,
  `TrainingData` tinyint(4) NOT NULL DEFAULT 0,
  `ctcData` tinyint(4) NOT NULL DEFAULT 0,
  `elgData` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionpaper`
--

CREATE TABLE `questionpaper` (
  `QPId` int(11) NOT NULL,
  `QuePaperName` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QId` int(11) NOT NULL,
  `QPId` int(11) NOT NULL,
  `Type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OptionA` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OptionB` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OptionC` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OptionD` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `CorrectAns` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `AttachImg` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `QOrder` int(11) NOT NULL,
  `Status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `screen2ndround`
--

CREATE TABLE `screen2ndround` (
  `SScId` int(11) NOT NULL,
  `ScId` int(11) NOT NULL,
  `InterAtt2` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IntervDt2` date NOT NULL,
  `IntervLoc2` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IntervPanel2` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IntervStatus2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Remarks` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `screening`
--

CREATE TABLE `screening` (
  `ScId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `ReSentForScreen` date NOT NULL,
  `ScrCmp` int(11) NOT NULL,
  `ScrDpt` int(11) NOT NULL,
  `ScreeningBy` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ResScreened` date NOT NULL,
  `ScreenStatus` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SueDept1` int(11) NOT NULL,
  `SueDept2` int(11) NOT NULL,
  `SueDept3` int(11) NOT NULL,
  `RejectionRem` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SendInterMail` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `InterAtt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IntervDt` date NOT NULL,
  `IntervTime` time NOT NULL,
  `IntervLoc` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IntervPanel` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `travelEligibility` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IntervStatus` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SelectedForC` int(11) NOT NULL,
  `SelectedForD` int(11) NOT NULL,
  `Remarks` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_agreement`
--

CREATE TABLE `service_agreement` (
  `AId` int(11) NOT NULL,
  `ServAgr` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `JAId` int(11) NOT NULL,
  `A_Date` date NOT NULL,
  `CreateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) NOT NULL,
  `LastUpdateTime` datetime NOT NULL,
  `LastUpdateBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_bond`
--

CREATE TABLE `service_bond` (
  `BId` int(11) NOT NULL,
  `JAId` int(11) NOT NULL,
  `B_Date` date NOT NULL,
  `ServBond` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) NOT NULL,
  `LastUpdateTime` datetime NOT NULL,
  `LastUpdateBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `StateId` int(8) NOT NULL,
  `StateName` varchar(100) NOT NULL,
  `StateCode` varchar(10) NOT NULL,
  `Status` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`StateId`, `StateName`, `StateCode`, `Status`) VALUES
(1, 'Andaman and Nicobar', 'AN', 'A'),
(2, 'Andhra Pradesh', 'AP', 'A'),
(3, 'Arunachal Pradesh', 'AR', 'A'),
(4, 'Assam', 'AS', 'A'),
(5, 'Bihar', 'BR', 'A'),
(6, 'Chandigarh', 'CH', 'A'),
(7, 'Chhattisgarh', 'CG', 'A'),
(8, 'Dadra and Nagar Haveli', 'DN', 'A'),
(9, 'Daman and Diu', 'DD', 'A'),
(10, 'Delhi', 'DL', 'A'),
(11, 'Goa', 'GA', 'A'),
(12, 'Gujarat', 'GJ', 'A'),
(13, 'Haryana', 'HR', 'A'),
(14, 'Himachal Pradesh', 'HP', 'A'),
(15, 'Jammu and Kashmir', 'JK', 'A'),
(16, 'Jharkhand', 'JH', 'A'),
(17, 'Karnataka', 'KA', 'A'),
(18, 'Kerala', 'KL', 'A'),
(19, 'Lakshdweep', 'LD', 'A'),
(20, 'Madhya Pradesh', 'MP', 'A'),
(21, 'Maharashtra', 'MH', 'A'),
(22, 'Manipur', 'MN', 'A'),
(23, 'Meghalaya', 'ML', 'A'),
(24, 'Mizoram', 'MZ', 'A'),
(25, 'Nagaland', 'NL', 'A'),
(26, 'Odisha', 'OD', 'A'),
(27, 'Puducherry', 'PY', 'A'),
(28, 'Punjab', 'PB', 'A'),
(29, 'Rajasthan', 'RJ', 'A'),
(30, 'Sikkim', 'SK', 'A'),
(31, 'Tamil Nadu', 'TN', 'A'),
(32, 'Tripura', 'TR', 'A'),
(33, 'Uttar Pradesh', 'UP', 'A'),
(34, 'Uttarakhand', 'UK', 'A'),
(35, 'West Bengal', 'WB', 'A'),
(36, 'Ladakh', 'LA', 'A'),
(37, 'Telangana', 'TS', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `theme_customizer`
--

CREATE TABLE `theme_customizer` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ThemeStyle` varchar(100) DEFAULT NULL,
  `SidebarColor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theme_customizer`
--

INSERT INTO `theme_customizer` (`Id`, `UserId`, `ThemeStyle`, `SidebarColor`) VALUES
(1, 1, 'minimal-theme', '');

-- --------------------------------------------------------

--
-- Table structure for table `trainee_details`
--

CREATE TABLE `trainee_details` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `university` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` int(11) NOT NULL,
  `doj` date NOT NULL,
  `doc` date DEFAULT NULL COMMENT 'date of completion',
  `reporting` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stipend` int(11) NOT NULL,
  `expdata` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contact` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `Username`, `email`, `Contact`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `Status`) VALUES
(1, 'Admin', 'admin', 'admin@admin.com', '', 'A', NULL, '$2y$10$ZwJWSgF2eEh5MGXmRuPn3ucnbO7O6K9wjZR3Rv.5M9owOilWE5P6W', NULL, '2021-07-15 16:49:53', '2021-07-15 16:49:53', 'A'),
(7, 'KRISHAN  UPADHYAY', 'kcupadhyay', 'kc@vnrseeds.com', '8008261509', 'H', NULL, '$2y$10$rYjTz48axCDJPItKcXKsP.elQuj/pLsD2YBRgcWPeeylDuwsAlxxW', NULL, '2021-07-27 15:40:24', '2021-07-27 15:40:24', 'A'),
(28, 'NANDKISHORE SHARMA', 'nksharma', 'nandkishore.sharma@vnrseeds.com', '9302847007', 'H', NULL, '$2y$10$cOWa8DX2cVXCZVqNsDUj5.d4awhBg5SkJTsm2vD9lUUH.zoFP.yWa', NULL, '2021-07-27 15:35:13', '2021-07-27 15:35:13', 'A'),
(51, 'ATUL SAH', 'atul', 'atul.sah@vnrseeds.com', '9630040330', 'H', NULL, '$2y$10$dGHuMCWYIOyjVV.Gpz8RPOdP9BU5EtIe4kNlXPPxb1btgzrRpP0hq', NULL, '2021-07-27 15:36:43', '2021-07-27 15:36:43', 'A'),
(52, 'RAJ KUNDU', 'rajkumar', 'rajkumar.kundu@vnrseeds.com', '9302840331', 'H', NULL, '$2y$10$8qYbhPoeJllGDInccc0ClO5JKm5XwHCQqv/U7nx8iW3cTSK1MjWTu', NULL, '2021-07-27 15:37:15', '2021-07-27 15:37:15', 'A'),
(65, 'ASHOK PATEL', 'ashok', 'ashok.patel@vnrseeds.com', '9300040330', 'H', NULL, '$2y$10$g9DVzPwrh.as8v1fWt2HEeOE/4K79mVjvAOCmj6bMVjGRxf3yYwZy', NULL, '2021-07-27 15:39:36', '2021-07-27 15:39:36', 'A'),
(89, 'PARAG AGARWAL', 'parag', 'parag.agarwal@vnrseeds.com', '9573678382', 'H', NULL, '$2y$10$GaLbbH0TY0CZ/oPnB/aPzuXUH.bOU4fwLQcxPiejnaZOMygoYz7WC', NULL, '2021-07-27 15:44:16', '2021-07-27 15:44:16', 'A'),
(109, 'MANISH KARKUN', 'manish', 'manish.karkun@vnrseeds.com', '9685436177', 'H', NULL, '$2y$10$aLvCW7oeR9nImuS7L4qWQ.2zxx5.6VRWyFcIu246sRLUhm9gJwSUm', NULL, '2021-07-27 15:25:59', '2021-07-27 15:25:59', 'A'),
(110, 'ASHISH BAJPAI', 'ashish', 'gm.finance@vnrseeds.com', '9301260007', 'H', NULL, '$2y$10$cPWIlsfQxJ/RZGlhproOqOwEWUeaOf27plYIbaAgv0AYo0g3YckSm', NULL, '2021-07-27 15:26:59', '2021-07-27 15:26:59', 'A'),
(140, 'HITENDRA SINGH', 'hitendra', 'hitendra.singh@vnrseeds.com', '9303540553', 'H', NULL, '$2y$10$qwgEsm3sx6MoqEslrzG/YOS70i2xXPQ/5Ga3raL2VR5sL29Oda3ji', NULL, '2021-07-27 15:28:46', '2021-07-27 15:28:46', 'A'),
(142, 'PARUL PARMAR', 'parul', 'parul.parmar@vnrseeds.com', '9300125137', 'H', NULL, '$2y$10$1agVLcnJy0ooYBzx8lQ.K.gDjLzVYzEeaurVdcUMtYf42Toh4YW0i', NULL, '2021-07-27 15:29:19', '2021-07-27 15:29:19', 'A'),
(182, 'DEBRAT ROY', 'debrat', 'debrat.roy@vnrseeds.com', '9300456007', 'R', NULL, '$2y$10$TGmxnraDWwX7xiGwqVg/neqqyJ8AzaMV2IXTXvbu3rO9BBdhjijCK', NULL, '2021-07-27 15:29:49', '2021-07-27 15:29:49', 'A'),
(195, 'HARI   ', 'hariprasad', 'hariprasad.verma@vnrseeds.in', '9981995392', 'H', NULL, '$2y$10$4eVJVhYojcgHPafJH5nv1uNj5CqaDwu3IV6gNHTuRrSfIV07S34dq', NULL, '2021-07-27 15:32:13', '2021-07-27 15:32:13', 'A'),
(223, 'ARVIND AGRAWAL', 'arvind', 'fd@vnrseeds.com', '9329570007', 'H', NULL, '$2y$10$QvcRsuh6MijxH1tf26EURO48T27nByyFJ00C83o5T6.8DnRVGXfae', NULL, '2021-07-27 15:36:13', '2021-07-27 15:36:13', 'A'),
(224, 'VIMAL CHAWDA', 'vimal', 'vimal.chawda@vnrseeds.com', '9981990330', 'H', NULL, '$2y$10$n5DrrPjXQMePsDs/Y8Gr..S/NGgNPXBa3bovxIa2Q/OHVp/fWqEuq', NULL, '2021-07-27 15:33:17', '2021-07-27 15:33:17', 'A'),
(254, 'DEVESH  SHUKLA', 'devesh', 'devesh.shukla@vnrnursery.in', '9981995393', 'H', NULL, '$2y$10$A6d6.sTADYxn3I3TWBoBnexCm7USNov.tLIZS12YWny3u/XwI1f9G', NULL, '2021-07-27 15:33:42', '2021-07-27 15:33:42', 'A'),
(263, 'SHEKHAR SATI', 'scsati', 'sc.sati@vnrseeds.com', '9981993070', 'H', NULL, '$2y$10$H4fYNyjUy2BslJ3Eyi1LU.4rt2PkHzKRKNs.Sdfwm1a0LxWNiLH9i', NULL, '2021-07-27 15:34:31', '2021-07-27 15:34:31', 'A'),
(321, 'RAJENDRA RANA', 'rajendrarana', 'rajendra.rana@vnrseeds.com', '8295177330', 'H', NULL, '$2y$10$Z4DWCiJTUTnoPhmbg6mSDe/m61XHyF1wQOkmDQfgy3y.jMmD.w/Si', NULL, '2021-07-27 15:35:47', '2021-07-27 15:35:47', 'A'),
(531, 'KUMAR RAHUL', 'krahul', 'kumar.rahul@vnrseeds.com', '9177030653', 'H', NULL, '$2y$10$N8PmyjyXfE36Ccvl24QqRecbiNEH8DyffDT9vr9otguMKNd0x0Evq', NULL, '2021-07-27 15:38:20', '2021-07-27 15:38:20', 'A'),
(544, 'SHEETAL DEWANGAN', 'sheetal', 'sheetal.dewangan@vnrseeds.com', '9516538080', 'H', NULL, '$2y$10$MTPdKgjikrlIGz3JHe9LhetEfrMcXrC5Ddhm6LkpELX2erw7iLgni', NULL, '2021-07-27 15:38:43', '2021-07-27 15:38:43', 'A'),
(601, 'KISLAY SINHA', 'kislay', 'kislay.sinha@vnrseeds.com', '9279133837', 'H', NULL, '$2y$10$m6szh1AZ6augtxk34IRxWOJc9k0gwxqpmBgDlJcjWFJrNsbFD/44e', NULL, '2021-07-27 15:39:10', '2021-07-27 15:39:10', 'A'),
(719, 'AMIT KUMAR', 'amitupadhyay', 'amit.upadhyay@vnrseeds.com', '9811332133', 'H', NULL, '$2y$10$FyIdrl/ta9Y0LTOfVWvY4OWDbkYfzgk4rAexMu3R8g1H14HvD1DaS', NULL, '2021-07-27 15:42:23', '2021-07-27 15:42:23', 'A'),
(762, 'ARUSHI DUTTA', 'arushi', 'arushi.dutta@vnrseeds.com', '8871272008', 'R', NULL, '$2y$10$XVQLI0zq4cdxsrVaas4pwuwzReaZxvfD6dq1LzAB5jmRJ8KfQOHoW', NULL, '2021-07-27 15:42:46', '2021-07-27 15:42:46', 'A'),
(1313, 'DIMPLE WADHWANI', 'dimple', 'dimple.wadhwani@vnrseeds.com', '7987221933', 'R', NULL, '$2y$10$UHPorzZUEu7qdSDbKbZlxuczYD9uW4itbI6gKNOxaVbsP4tnBgIi6', NULL, '2021-07-27 15:28:13', '2021-07-27 15:28:13', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `userTypeId` int(11) NOT NULL,
  `userType` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`AId`);

--
-- Indexes for table `appointing`
--
ALTER TABLE `appointing`
  ADD PRIMARY KEY (`AppointId`);

--
-- Indexes for table `campus_costing`
--
ALTER TABLE `campus_costing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidateeducation`
--
ALTER TABLE `candidateeducation`
  ADD PRIMARY KEY (`CEId`);

--
-- Indexes for table `candidate_ctc`
--
ALTER TABLE `candidate_ctc`
  ADD PRIMARY KEY (`CTCId`);

--
-- Indexes for table `candidate_entitlement`
--
ALTER TABLE `candidate_entitlement`
  ADD PRIMARY KEY (`ENTId`);

--
-- Indexes for table `candidate_ref`
--
ALTER TABLE `candidate_ref`
  ADD PRIMARY KEY (`REFId`);

--
-- Indexes for table `candjoining`
--
ALTER TABLE `candjoining`
  ADD PRIMARY KEY (`CJId`);

--
-- Indexes for table `examattempt`
--
ALTER TABLE `examattempt`
  ADD PRIMARY KEY (`AttemptId`);

--
-- Indexes for table `examroom`
--
ALTER TABLE `examroom`
  ADD PRIMARY KEY (`RoomId`);

--
-- Indexes for table `firob`
--
ALTER TABLE `firob`
  ADD PRIMARY KEY (`FirobId`);

--
-- Indexes for table `firob_object`
--
ALTER TABLE `firob_object`
  ADD PRIMARY KEY (`FirobOId`);

--
-- Indexes for table `firob_qset`
--
ALTER TABLE `firob_qset`
  ADD PRIMARY KEY (`FirobQSetId`);

--
-- Indexes for table `firob_user`
--
ALTER TABLE `firob_user`
  ADD PRIMARY KEY (`FirobUId`);

--
-- Indexes for table `hrm_employee_reporting`
--
ALTER TABLE `hrm_employee_reporting`
  ADD PRIMARY KEY (`ReportingId`);

--
-- Indexes for table `intervcost`
--
ALTER TABLE `intervcost`
  ADD PRIMARY KEY (`ICId`);

--
-- Indexes for table `jf_about_ans`
--
ALTER TABLE `jf_about_ans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_about_questionare`
--
ALTER TABLE `jf_about_questionare`
  ADD PRIMARY KEY (`aqid`);

--
-- Indexes for table `jf_contact_det`
--
ALTER TABLE `jf_contact_det`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_docs`
--
ALTER TABLE `jf_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_docs_more`
--
ALTER TABLE `jf_docs_more`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_family_det`
--
ALTER TABLE `jf_family_det`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_language`
--
ALTER TABLE `jf_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_pf_esic`
--
ALTER TABLE `jf_pf_esic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_reference`
--
ALTER TABLE `jf_reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_tranprac`
--
ALTER TABLE `jf_tranprac`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jf_work_exp`
--
ALTER TABLE `jf_work_exp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobapply`
--
ALTER TABLE `jobapply`
  ADD PRIMARY KEY (`JAId`);

--
-- Indexes for table `jobcandidates`
--
ALTER TABLE `jobcandidates`
  ADD PRIMARY KEY (`JCId`);

--
-- Indexes for table `jobpost`
--
ALTER TABLE `jobpost`
  ADD PRIMARY KEY (`JPId`);

--
-- Indexes for table `jsonpushchktbl`
--
ALTER TABLE `jsonpushchktbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keypostioncriteria`
--
ALTER TABLE `keypostioncriteria`
  ADD PRIMARY KEY (`KPCId`);

--
-- Indexes for table `launchexam`
--
ALTER TABLE `launchexam`
  ADD PRIMARY KEY (`ExamId`);

--
-- Indexes for table `launchexam_exams`
--
ALTER TABLE `launchexam_exams`
  ADD PRIMARY KEY (`LEEId`);

--
-- Indexes for table `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manpowerrequisition`
--
ALTER TABLE `manpowerrequisition`
  ADD PRIMARY KEY (`MRFId`);

--
-- Indexes for table `master_city`
--
ALTER TABLE `master_city`
  ADD PRIMARY KEY (`CityId`);

--
-- Indexes for table `master_company`
--
ALTER TABLE `master_company`
  ADD PRIMARY KEY (`CompanyId`);

--
-- Indexes for table `master_country`
--
ALTER TABLE `master_country`
  ADD PRIMARY KEY (`CountryId`);

--
-- Indexes for table `master_department`
--
ALTER TABLE `master_department`
  ADD PRIMARY KEY (`DepartmentId`);

--
-- Indexes for table `master_dept_shortcodes`
--
ALTER TABLE `master_dept_shortcodes`
  ADD PRIMARY KEY (`DeptShortId`);

--
-- Indexes for table `master_designation`
--
ALTER TABLE `master_designation`
  ADD PRIMARY KEY (`DesigId`);

--
-- Indexes for table `master_district`
--
ALTER TABLE `master_district`
  ADD PRIMARY KEY (`DistrictId`);

--
-- Indexes for table `master_education`
--
ALTER TABLE `master_education`
  ADD PRIMARY KEY (`EducationId`);

--
-- Indexes for table `master_employee`
--
ALTER TABLE `master_employee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `master_emp_position_codes`
--
ALTER TABLE `master_emp_position_codes`
  ADD PRIMARY KEY (`EmPosCodeID`);

--
-- Indexes for table `master_grade`
--
ALTER TABLE `master_grade`
  ADD PRIMARY KEY (`GradeId`);

--
-- Indexes for table `master_headquater`
--
ALTER TABLE `master_headquater`
  ADD PRIMARY KEY (`HqId`);

--
-- Indexes for table `master_institute`
--
ALTER TABLE `master_institute`
  ADD PRIMARY KEY (`InstituteId`);

--
-- Indexes for table `master_location`
--
ALTER TABLE `master_location`
  ADD PRIMARY KEY (`LocationId`);

--
-- Indexes for table `master_pages`
--
ALTER TABLE `master_pages`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `master_resumesource`
--
ALTER TABLE `master_resumesource`
  ADD PRIMARY KEY (`ResumeSouId`);

--
-- Indexes for table `master_specialization`
--
ALTER TABLE `master_specialization`
  ADD PRIMARY KEY (`SpId`);

--
-- Indexes for table `master_state`
--
ALTER TABLE `master_state`
  ADD PRIMARY KEY (`StateId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offerletterbasic`
--
ALTER TABLE `offerletterbasic`
  ADD PRIMARY KEY (`OfLeId`);

--
-- Indexes for table `page_permissions`
--
ALTER TABLE `page_permissions`
  ADD PRIMARY KEY (`upid`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `previous_screening`
--
ALTER TABLE `previous_screening`
  ADD PRIMARY KEY (`PSCId`);

--
-- Indexes for table `processdatatoess`
--
ALTER TABLE `processdatatoess`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `questionpaper`
--
ALTER TABLE `questionpaper`
  ADD PRIMARY KEY (`QPId`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QId`);

--
-- Indexes for table `screen2ndround`
--
ALTER TABLE `screen2ndround`
  ADD PRIMARY KEY (`SScId`);

--
-- Indexes for table `screening`
--
ALTER TABLE `screening`
  ADD PRIMARY KEY (`ScId`);

--
-- Indexes for table `service_agreement`
--
ALTER TABLE `service_agreement`
  ADD PRIMARY KEY (`AId`);

--
-- Indexes for table `service_bond`
--
ALTER TABLE `service_bond`
  ADD PRIMARY KEY (`BId`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`StateId`);

--
-- Indexes for table `theme_customizer`
--
ALTER TABLE `theme_customizer`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `trainee_details`
--
ALTER TABLE `trainee_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`userTypeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `AId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointing`
--
ALTER TABLE `appointing`
  MODIFY `AppointId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campus_costing`
--
ALTER TABLE `campus_costing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidateeducation`
--
ALTER TABLE `candidateeducation`
  MODIFY `CEId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_ctc`
--
ALTER TABLE `candidate_ctc`
  MODIFY `CTCId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_entitlement`
--
ALTER TABLE `candidate_entitlement`
  MODIFY `ENTId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_ref`
--
ALTER TABLE `candidate_ref`
  MODIFY `REFId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candjoining`
--
ALTER TABLE `candjoining`
  MODIFY `CJId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examattempt`
--
ALTER TABLE `examattempt`
  MODIFY `AttemptId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examroom`
--
ALTER TABLE `examroom`
  MODIFY `RoomId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firob`
--
ALTER TABLE `firob`
  MODIFY `FirobId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firob_object`
--
ALTER TABLE `firob_object`
  MODIFY `FirobOId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firob_qset`
--
ALTER TABLE `firob_qset`
  MODIFY `FirobQSetId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firob_user`
--
ALTER TABLE `firob_user`
  MODIFY `FirobUId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intervcost`
--
ALTER TABLE `intervcost`
  MODIFY `ICId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_about_ans`
--
ALTER TABLE `jf_about_ans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_about_questionare`
--
ALTER TABLE `jf_about_questionare`
  MODIFY `aqid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_contact_det`
--
ALTER TABLE `jf_contact_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_docs`
--
ALTER TABLE `jf_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_docs_more`
--
ALTER TABLE `jf_docs_more`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_family_det`
--
ALTER TABLE `jf_family_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_language`
--
ALTER TABLE `jf_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_pf_esic`
--
ALTER TABLE `jf_pf_esic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_reference`
--
ALTER TABLE `jf_reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_tranprac`
--
ALTER TABLE `jf_tranprac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jf_work_exp`
--
ALTER TABLE `jf_work_exp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobapply`
--
ALTER TABLE `jobapply`
  MODIFY `JAId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobcandidates`
--
ALTER TABLE `jobcandidates`
  MODIFY `JCId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobpost`
--
ALTER TABLE `jobpost`
  MODIFY `JPId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jsonpushchktbl`
--
ALTER TABLE `jsonpushchktbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keypostioncriteria`
--
ALTER TABLE `keypostioncriteria`
  MODIFY `KPCId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `launchexam`
--
ALTER TABLE `launchexam`
  MODIFY `ExamId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `launchexam_exams`
--
ALTER TABLE `launchexam_exams`
  MODIFY `LEEId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manpowerrequisition`
--
ALTER TABLE `manpowerrequisition`
  MODIFY `MRFId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_city`
--
ALTER TABLE `master_city`
  MODIFY `CityId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_company`
--
ALTER TABLE `master_company`
  MODIFY `CompanyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_country`
--
ALTER TABLE `master_country`
  MODIFY `CountryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_department`
--
ALTER TABLE `master_department`
  MODIFY `DepartmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `master_dept_shortcodes`
--
ALTER TABLE `master_dept_shortcodes`
  MODIFY `DeptShortId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_designation`
--
ALTER TABLE `master_designation`
  MODIFY `DesigId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=626;

--
-- AUTO_INCREMENT for table `master_district`
--
ALTER TABLE `master_district`
  MODIFY `DistrictId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=704;

--
-- AUTO_INCREMENT for table `master_education`
--
ALTER TABLE `master_education`
  MODIFY `EducationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_emp_position_codes`
--
ALTER TABLE `master_emp_position_codes`
  MODIFY `EmPosCodeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_grade`
--
ALTER TABLE `master_grade`
  MODIFY `GradeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `master_headquater`
--
ALTER TABLE `master_headquater`
  MODIFY `HqId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=408;

--
-- AUTO_INCREMENT for table `master_institute`
--
ALTER TABLE `master_institute`
  MODIFY `InstituteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_location`
--
ALTER TABLE `master_location`
  MODIFY `LocationId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_pages`
--
ALTER TABLE `master_pages`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_resumesource`
--
ALTER TABLE `master_resumesource`
  MODIFY `ResumeSouId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_specialization`
--
ALTER TABLE `master_specialization`
  MODIFY `SpId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_state`
--
ALTER TABLE `master_state`
  MODIFY `StateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offerletterbasic`
--
ALTER TABLE `offerletterbasic`
  MODIFY `OfLeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_permissions`
--
ALTER TABLE `page_permissions`
  MODIFY `upid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `previous_screening`
--
ALTER TABLE `previous_screening`
  MODIFY `PSCId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `processdatatoess`
--
ALTER TABLE `processdatatoess`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questionpaper`
--
ALTER TABLE `questionpaper`
  MODIFY `QPId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `screen2ndround`
--
ALTER TABLE `screen2ndround`
  MODIFY `SScId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `screening`
--
ALTER TABLE `screening`
  MODIFY `ScId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_agreement`
--
ALTER TABLE `service_agreement`
  MODIFY `AId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_bond`
--
ALTER TABLE `service_bond`
  MODIFY `BId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `StateId` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `theme_customizer`
--
ALTER TABLE `theme_customizer`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trainee_details`
--
ALTER TABLE `trainee_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `userTypeId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
