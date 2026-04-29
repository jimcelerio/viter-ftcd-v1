import React from "react";
import Layout from "./Layout";

const PlaceholderPage = ({ menu = "", submenu = "" }) => {
  return <Layout menu={menu} submenu={submenu} />;
};

export default PlaceholderPage;
