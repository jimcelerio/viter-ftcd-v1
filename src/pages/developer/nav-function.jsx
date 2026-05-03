import { MdDashboard } from "react-icons/md";
import { devNavUrl, urlDeveloper } from "../../functions/functions-general";
import {
  FaClipboardList,
  FaCogs,
  FaHandHoldingHeart,
  FaListUl,
  FaUsers,
} from "react-icons/fa";
import { FaChildren, FaGear } from "react-icons/fa6";

export const navList = [
  {
    label: "Donor List",
    icon: <FaHandHoldingHeart />,
    menu: "donorlist",
    path: `${devNavUrl}/${urlDeveloper}/donorlist`,
    submenu: "",
  },
  {
    label: "Children List",
    icon: <FaChildren />,
    menu: "children-list",
    path: `${devNavUrl}/${urlDeveloper}/children-list`,
    submenu: "",
  },
  {
    label: "Reports",
    icon: <FaListUl />,
    menu: "reports",
    submenu: "",
    subNavList: [
      {
        label: "Donations",
        submenu: "donations",
        path: `${devNavUrl}/${urlDeveloper}/reports/donations`,
      },
      {
        label: "Contact Us",
        submenu: "contact-us",
        path: `${devNavUrl}/${urlDeveloper}/reports/contact-us`,
      },
      {
        label: "FAQ",
        submenu: "faq",
        path: `${devNavUrl}/${urlDeveloper}/reports/faq`,
      },
    ],
  },
  {
    label: "Settings",
    icon: <FaGear />,
    menu: "settings",
    submenu: "",
    subNavList: [
      {
        label: "Users",
        submenu: "users",
        path: `${devNavUrl}/${urlDeveloper}/settings/users`,
      },
      {
        label: "Category",
        submenu: "category",
        path: `${devNavUrl}/${urlDeveloper}/settings/category`,
      },
      {
        label: "Designation",
        submenu: "designation",
        path: `${devNavUrl}/${urlDeveloper}/settings/designation`,
      },
      {
        label: "Notification",
        submenu: "notification",
        path: `${devNavUrl}/${urlDeveloper}/settings/notification`,
      },
      {
        label: "Maintenance",
        submenu: "maintenance",
        path: `${devNavUrl}/${urlDeveloper}/settings/maintenance`,
      },
    ],
  },
];
