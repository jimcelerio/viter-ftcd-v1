import React from "react";
import Header from "../../partials/Header";
import Navigation from "../../partials/Navigation";
import { navList } from "./nav-function";
import ModalSuccess from "../../partials/modals/ModalSuccess";
import { StoreContext } from "../../store/StoreContext";
import { Link, useLocation } from "react-router-dom";

const formatCrumb = (value = "") =>
  value
    .replaceAll("-", " ")
    .split(" ")
    .filter(Boolean)
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");

const Layout = ({ children, menu = "", submenu = "" }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  const location = useLocation();
  const segments = location.pathname.split("/").filter(Boolean);
  const settingsIndex = segments.findIndex((segment) => segment === "settings");
  const isSettingsPage = settingsIndex !== -1;
  const settingsCrumbs = isSettingsPage
    ? segments.slice(settingsIndex).map((segment, index, arr) => {
        const path = `/${segments.slice(0, settingsIndex + index + 1).join("/")}`;
        return {
          label: formatCrumb(segment),
          path,
          isLast: index === arr.length - 1,
        };
      })
    : [];

  return (
    <>
      {/* HEADER */}
      <Header />

      {/* NAVIGATION */}
      <Navigation menu={menu} submenu={submenu} navigationList={navList} />

      {/* BODY */}
      <div className="wrapper flex flex-col">
        <div className="flex-1">
          {isSettingsPage && (
            <div className="mb-2 mt-1">
              <ul className="flex items-center gap-1.5 text-xs leading-none">
                {settingsCrumbs.map((crumb) => (
                  <li key={crumb.path} className="flex items-center gap-1.5">
                    {crumb.isLast ? (
                      <span className="text-gray-700">{crumb.label}</span>
                    ) : (
                      <>
                        <Link to={crumb.path} className="text-primary hover:underline">
                          {crumb.label}
                        </Link>
                        <span className="text-gray-400">{">"}</span>
                      </>
                    )}
                  </li>
                ))}
              </ul>
            </div>
          )}
          {children}
        </div>

        <footer className="py-4 text-center text-[11px] leading-snug text-gray-700">
          <p className="mb-0">© 2026 All rights reserved.</p>
          <p className="mb-0">
            Powered by <span className="text-primary">Frontline Business Solutions, Inc.</span>
          </p>
        </footer>
      </div>

      {/* FOOTER */}

      {/* MODAL SUCCESS */}
      {store.success && <ModalSuccess />}
    </>
  );
};

export default Layout;
