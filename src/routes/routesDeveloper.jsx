import { devNavUrl, urlDeveloper } from "../functions/functions-general";
import DonorsList from "../pages/developer/donorlist/Donors";
import Users from "../pages/developer/settings/users/Users";
import PlaceholderPage from "../pages/developer/PlaceholderPage";
import Roles from "../pages/developer/settings/users/roles/Roles";
import SystemUsers from "../pages/developer/settings/users/system-users/SystemUsers";
import Category from "../pages/developer/settings/category/Category";

export const routesDeveloper = [
  {
    path: `${devNavUrl}/${urlDeveloper}/`,
    element: (
      <>
        <DonorsList />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/donorlist`,
    element: (
      <>
        <DonorsList />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/users`,
    element: (
      <>
        <Users />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/users/roles`,
    element: (
      <>
        <Roles />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/users/system-users`,
    element: (
      <>
        <SystemUsers />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/children-list`,
    element: (
      <>
        <PlaceholderPage menu="children-list" />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/reports/donations`,
    element: (
      <>
        <PlaceholderPage menu="reports" submenu="donations" />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/reports/contact-us`,
    element: (
      <>
        <PlaceholderPage menu="reports" submenu="contact-us" />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/reports/faq`,
    element: (
      <>
        <PlaceholderPage menu="reports" submenu="faq" />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/category`,
    element: (
      <>
        <Category />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/designation`,
    element: (
      <>
        <PlaceholderPage menu="settings" submenu="designation" />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/notification`,
    element: (
      <>
        <PlaceholderPage menu="settings" submenu="notification" />
      </>
    ),
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/maintenance`,
    element: (
      <>
        <PlaceholderPage menu="settings" submenu="maintenance" />
      </>
    ),
  },
];
