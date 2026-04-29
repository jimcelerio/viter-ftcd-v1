# VITER-FTCD-V1 PROJECT DOCUMENTATION

## Face The Children - Donor Management System

---

## 1. PROJECT OVERVIEW

- **Project Name**: viter-ftcd-v1
- **Framework**: React 19 + Vite + Tailwind CSS v4 + PHP REST API
- **State Management**: React Context API + useReducer
- **Data Fetching**: TanStack Query (React Query) v5
- **Form Handling**: Formik + Yup
- **Database**: MySQL (viter_ftcd_v1)
- **Server**: XAMPP (Apache + MySQL)

---

## 2. DIRECTORY STRUCTURE

```
viter-ftcd-v1/
├── .gitignore
├── eslint.config.js
├── index.html
├── package.json
├── package-lock.json
├── README.md
├── vite.config.js
├── fonts/
│   └── poppins-regular.woff
├── public/
│   └── logo.svg
├── rest/
│   └── v1/
│       ├── .htaccess
│       ├── core/
│       │   ├── Database.php
│       │   ├── functions.php
│       │   ├── header.php
│       │   └── Response.php
│       ├── db-backup/
│       │   └── viter_ftcd_v1.sql
│       ├── controllers/
│       │   ├── admin/
│       │   └── developers/
│       │       ├── donors/
│       │       │   ├── active.php
│       │       │   ├── create.php
│       │       │   ├── delete.php
│       │       │   ├── donors.php
│       │       │   ├── page.php
│       │       │   ├── read.php
│       │       │   └── update.php
│       │       └── settings/
│       └── models/
│           └── developers/
│               ├── donors/
│               │   └── Donors.php
│               └── settings/
└── src/
    ├── App.jsx
    ├── index.css
    ├── main.jsx
    ├── assets/
    │   └── ftc_logo.png
    ├── components/
    │   └── form-input/
    │       └── FormInputs.jsx
    ├── functions/
    │   ├── functions-general.jsx
    │   └── custom-hooks/
    │       ├── fetchApi.jsx
    │       ├── queryData.jsx
    │       ├── queryDataInfinite.jsx
    │       └── useQueryData.jsx
    ├── pages/
    │   └── developer/
    │       ├── Layout.jsx
    │       ├── nav-function.jsx
    │       ├── donorlist/
    │       │   ├── Donors.jsx
    │       │   ├── DonorsList.jsx
    │       │   └── ModalAddDonors.jsx
    │       └── settings/
    │           └── users/
    │               └── Users.jsx
    ├── partials/
    │   ├── BreadCrumbs.jsx
    │   ├── ComeBackLater.jsx
    │   ├── Header.jsx
    │   ├── Loadmore.jsx
    │   ├── MessageError.jsx
    │   ├── Navigation.jsx
    │   ├── NavigationAccordions.jsx
    │   ├── NoData.jsx
    │   ├── PageNotFound.jsx
    │   ├── SearchBar.jsx
    │   ├── ServerError.jsx
    │   ├── Status.jsx
    │   ├── TableLoading.jsx
    │   ├── modals/
    │   │   ├── ModalArchive.jsx
    │   │   ├── ModalDelete.jsx
    │   │   ├── ModalDeleteAssociated.jsx
    │   │   ├── ModalError.jsx
    │   │   ├── ModalRemovedFile.jsx
    │   │   ├── ModalRestore.jsx
    │   │   ├── ModalSendingEmailStatus.jsx
    │   │   ├── ModalSentEmailSummary.jsx
    │   │   ├── ModalSuccess.jsx
    │   │   ├── ModalWrapperCenter.jsx
    │   │   └── ModalWrapperSide.jsx
    │   └── spinners/
    │       ├── ButtonSpinner.jsx
    │       ├── ButtonSpinnerSize.jsx
    │       ├── ContentSpinner.jsx
    │       ├── FetchingSpinner.jsx
    │       ├── ReceiptScreenSpinner.jsx
    │       ├── ScreenSpinner.jsx
    │       └── TableSpinner.jsx
    ├── routes/
    │   └── routesDeveloper.jsx
    └── store/
        ├── StoreAction.jsx
        ├── StoreContext.jsx
        └── StoreReducer.jsx
```

---

## 3. FRONTEND (REACT)

### 3.1 Entry Points

**index.html** - Main HTML template

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/logo.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Face The Children</title>
  </head>
  <body>
    <div id="root"></div>
    <script type="module" src="/src/main.jsx"></script>
  </body>
</html>
```

**src/main.jsx** - React application entry point

```jsx
import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import App from "./App.jsx";

createRoot(document.getElementById("root")).render(
  <StrictMode>
    <App />
  </StrictMode>
);
```

### 3.2 App Component (Routing Setup)

**src/App.jsx**

```jsx
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import {
  Navigate,
  Route,
  BrowserRouter as Router,
  Routes,
} from "react-router-dom";
import PageNotFound from "./partials/PageNotFound";
import { routesDeveloper } from "./routes/routesDeveloper";
import { StoreProvider } from "./store/StoreContext";

function App() {
  const queryClient = new QueryClient();
  return (
    <>
      <QueryClientProvider client={queryClient}>
        <StoreProvider>
          <Router>
            <Routes>
              <Route
                path="/"
                element={<Navigate to="/developer/donorlist" replace />}
              />
              <Route path="*" element={<PageNotFound />} />

              {routesDeveloper.map(({ ...routesProps }, key) => {
                return <Route key={key} {...routesProps} />;
              })}
            </Routes>
          </Router>
        </StoreProvider>
      </QueryClientProvider>
    </>
  );
}

export default App;
```

### 3.3 Routes Configuration

**src/routes/routesDeveloper.jsx**

```jsx
import { devNavUrl, urlDeveloper } from "../functions/functions-general";
import DonorsList from "../pages/developer/donorlist/Donors";
import Users from "../pages/developer/settings/users/Users";

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
];
```

### 3.4 State Management (Context API + useReducer)

**src/store/StoreContext.jsx**

```jsx
import React from "react";
import { StoreReducer } from "./StoreReducer";
const isMobileOrTablet = window.matchMedia("(max-width:1027px)").matches;

const initVal = {
  error: false,
  success: false,
  isShow: isMobileOrTablet ? false : true,
  isArchive: false,
  isDelete: false,
  isRestore: false,
  isAdd: false,
  isSearch: false,
  isCreatePassSuccess: false,
  isForgotPassSuccess: false,
  isLogin: false,
  isLogout: false,
  isAccountUpdated: false,
  isLeaveOpen: false,
  isRoomOpen: false,
  isSettingsOpen: false,
  isKpiOpen: false,
  isPayrollOpen: false,
  isMemoOpen: false,
  isViewImage: false,
  isViewTab: false,
  isViewTabModal: false,
  isViewTabModalLog: false,
  isNewFeature: [],
  scrollPosition: 0,
  credentials: {
    data: {
      role: "developer",
      role_code: "r_is_developer",
      user_first_name: "John",
      user_last_name: "Doe",
      user_email: "john@gmail.com",
    },
  },
  filterValues: [],
  isAddAccomplishment: { modal: false, code: "" },
};

const StoreContext = React.createContext();

const StoreProvider = (props) => {
  const [store, dispatch] = React.useReducer(StoreReducer, initVal);

  return (
    <StoreContext.Provider value={{ store, dispatch }}>
      {props.children}
    </StoreContext.Provider>
  );
};

export { StoreContext, StoreProvider };
```

**src/store/StoreReducer.jsx**

```jsx
export const StoreReducer = (state, action) => {
  switch (action.type) {
    case "ERROR":
      return { ...state, error: action.payload };
    case "MESSAGE":
      return { ...state, message: action.payload };
    case "SUCCESS":
      return { ...state, success: action.payload };
    case "SHOW":
      return { ...state, isShow: action.payload };
    case "ARCHIVE":
      return { ...state, isArchive: action.payload };
    case "DELETE":
      return { ...state, isDelete: action.payload };
    case "RESTORE":
      return { ...state, isRestore: action.payload };
    case "IS_ADD":
      return { ...state, isAdd: action.payload };
    case "IS_SEARCH":
      return { ...state, isSearch: action.payload };
    case "IS_CREATE_PASS_SUCCCESS":
      return { ...state, isCreatePassSuccess: action.payload };
    case "IS_FORGET_PASS_SUCCCESS":
      return { ...state, isForgotPassSuccess: action.payload };
    case "IS_LOGIN":
      return { ...state, isLogin: action.payload };
    case "IS_LOGOUT":
      return { ...state, isLogout: action.payload };
    case "IS_ACCOUNT_UPDATED":
      return { ...state, isAccountUpdated: action.payload };
    case "IS_LEAVE_OPEN":
      return { ...state, isLeaveOpen: action.payload };
    case "IS_SETTINGS_OPEN":
      return { ...state, isSettingsOpen: action.payload };
    case "IS_ROOM_OPEN":
      return { ...state, isRoomOpen: action.payload };
    case "IS_KPI_OPEN":
      return { ...state, isKpiOpen: action.payload };
    case "IS_PAYROLL_OPEN":
      return { ...state, isPayrollOpen: action.payload };
    case "IS_MEMO_OPEN":
      return { ...state, isMemoOpen: action.payload };
    case "IS_VIEW_IMAGE":
      return { ...state, isViewImage: action.payload };
    case "IS_VIEW_TAB":
      return { ...state, isViewTab: action.payload };
    case "IS_VIEW_TAB_MODAL":
      return { ...state, isViewTabModal: action.payload };
    case "IS_VIEW_TAB_MODAL_LOG":
      return { ...state, isViewTabModalLog: action.payload };
    case "IS_NEW_FEATURE":
      return { ...state, isNewFeature: action.payload };
    case "SCROLL_POSITION":
      return { ...state, scrollPosition: action.payload };
    case "CREDENTIALS":
      return { ...state, credentials: action.payload };
    case "FILTER_VALUES":
      return { ...state, filterValues: action.payload };
    case "IS_ADD_ACCOMPLISHMENT":
      return { ...state, isAddAccomplishment: action.payload };
    default:
      return state;
  }
};
```

**src/store/StoreAction.jsx** - Action Creators

```jsx
export const setError = (val) => ({ type: "ERROR", payload: val });
export const setMessage = (val) => ({ type: "MESSAGE", payload: val });
export const setSuccess = (val) => ({ type: "SUCCESS", payload: val });
export const setIsShow = (val) => ({ type: "SHOW", payload: val });
export const setIsArchive = (val) => ({ type: "ARCHIVE", payload: val });
export const setIsDelete = (val) => ({ type: "DELETE", payload: val });
export const setIsRestore = (val) => ({ type: "RESTORE", payload: val });
export const setIsAdd = (val) => ({ type: "IS_ADD", payload: val });
export const setIsSearch = (val) => ({ type: "IS_SEARCH", payload: val });
export const setCreatePassSuccess = (val) => ({
  type: "IS_CREATE_PASS_SUCCCESS",
  payload: val,
});
export const setForgotPassSuccess = (val) => ({
  type: "IS_FORGET_PASS_SUCCCESS",
  payload: val,
});
export const setIsLogin = (val) => ({ type: "IS_LOGIN", payload: val });
export const setIsLogout = (val) => ({ type: "IS_LOGOUT", payload: val });
export const setIsAccountUpdated = (val) => ({
  type: "IS_ACCOUNT_UPDATED",
  payload: val,
});
export const setIsLeaveOpen = (val) => ({
  type: "IS_LEAVE_OPEN",
  payload: val,
});
export const setIsSettingsOpen = (val) => ({
  type: "IS_SETTINGS_OPEN",
  payload: val,
});
export const setIsKpiOpen = (val) => ({ type: "IS_KPI_OPEN", payload: val });
export const setIsRoomOpen = (val) => ({ type: "IS_ROOM_OPEN", payload: val });
export const setIsPayrollOpen = (val) => ({
  type: "IS_PAYROLL_OPEN",
  payload: val,
});
export const setIsMemoOpen = (val) => ({ type: "IS_MEMO_OPEN", payload: val });
export const setIsViewImage = (val) => ({
  type: "IS_VIEW_IMAGE",
  payload: val,
});
export const setIsViewTab = (val) => ({ type: "IS_VIEW_TAB", payload: val });
export const setIsViewTabModal = (val) => ({
  type: "IS_VIEW_TAB_MODAL",
  payload: val,
});
export const setIsViewTabModalLog = (val) => ({
  type: "IS_VIEW_TAB_MODAL_LOG",
  payload: val,
});
export const setIsNewFeature = (val) => ({
  type: "IS_NEW_FEATURE",
  payload: val,
});
export const setCredentials = (data) => ({
  type: "CREDENTIALS",
  payload: { data },
});
export const setScrollPosition = (val) => ({
  type: "SCROLL_POSITION",
  payload: val,
});
export const setFilterValues = (data) => ({
  type: "FILTER_VALUES",
  payload: data,
});
export const setIsAddAccomplishment = (val) => ({
  type: "IS_ADD_ACCOMPLISHMENT",
  payload: val,
});
```

### 3.5 General Functions & Configuration

**src/functions/functions-general.jsx**

```jsx
import React from "react";

export const urlPath = "http://localhost/react-vite/viter-ftcd-v1";
export const devNavUrl = "";
export const apiVersion = "/v1";
export const devApiUrl = urlPath + "/rest";

export const setTimezone = "Asia/Manila";

// Roles variable
export const urlDeveloper = "developer";
export const getUserType = () => `${devNavUrl}/${urlDeveloper}`;

// dev API KEY
export const devKey = "123devkey";

// format the numbers separated by comma
export const isEmptyItem = (item, x = "") => {
  let result = x;
  if (typeof item !== "undefined" && item !== "") {
    result = item;
  }
  return result;
};

export const formatDate = (dateVal, val = "", format = "") => {
  const formatedDate = val;
  if (typeof dateVal !== "undefined" && dateVal !== "") {
    const event = new Date(dateVal);
    return event.toLocaleString("en", dateOptions(format));
  }
  return formatedDate;
};

export const dateOptions = (format = "") => {
  let options = { month: "long", day: "numeric", year: "numeric" };
  if (format == "short-date") {
    return { month: "short", day: "numeric", year: "numeric" };
  }
  return options;
};

export const handleEscape = (handleClose) => {
  React.useEffect(() => {
    const handleEscape = (e) => {
      if (e.keyCode === 27) {
        handleClose();
      }
    };
    window.addEventListener("keydown", handleEscape);
    return () => window.removeEventListener("keydown", handleEscape);
  });
};

// get focus on a button
export const GetFocus = (id) => {
  React.useEffect(() => {
    const obj = document.getElementById(id);
    obj.focus();
  }, []);
};
```

### 3.6 Custom Hooks (Data Fetching)

**src/functions/custom-hooks/queryData.jsx**

```jsx
import { devApiUrl, devKey } from "../functions-general";

export const queryData = (endpoint, method = "get", fd = {}) => {
  let url = devApiUrl + endpoint;
  let username = devKey;
  let password = "";
  let auth = btoa(`${username}:${password}`);
  var myHeaders = new Headers();
  myHeaders.append("Authorization", "Basic " + auth);
  myHeaders.append("Content-Type", "application/json");

  let options = {
    method,
    headers: myHeaders,
  };

  if (method !== "get") {
    options = {
      ...options,
      body: JSON.stringify(fd),
    };
  }

  const data = fetch(url, options).then((res) => res.json());
  return data;
};
```

**src/functions/custom-hooks/queryDataInfinite.jsx**

```jsx
import { queryData } from "./queryData";

export const queryDataInfinite = (
  urlSearch,
  urlList,
  isSearch = false,
  searchData = isSearch ? searchData : {},
  method = "get"
) => {
  return queryData(isSearch ? urlSearch : urlList, method, searchData);
};
```

**src/functions/custom-hooks/useQueryData.jsx**

```jsx
import { useQuery } from "@tanstack/react-query";
import { queryData } from "./queryData";

const useQueryData = (
  endpoint,
  method,
  key = "",
  fd = {},
  id = null,
  refetchOnWindowFocus = false
) => {
  return useQuery({
    queryKey: [key, id],
    queryFn: async () => await queryData(endpoint, method, fd),
    retry: false,
    refetchOnWindowFocus: refetchOnWindowFocus,
    cacheTime: 200,
  });
};

export default useQueryData;
```

**src/functions/custom-hooks/fetchApi.jsx**

```jsx
const fetchApi = (url, fd = {}, dispatch = null) => {
  const data = fetch(url, {
    method: "post",
    headers: { "content-type": "application/json" },
    body: JSON.stringify(fd),
  })
    .then((res) => {
      return res.json();
    })
    .catch((error) => {
      console.log(error);
      return false;
    });
  return data;
};

export default fetchApi;
```

### 3.7 Layout & Navigation

**src/pages/developer/Layout.jsx**

```jsx
import React from "react";
import Header from "../../partials/Header";
import Navigation from "../../partials/Navigation";
import { navList } from "./nav-function";
import ModalSuccess from "../../partials/modals/ModalSuccess";
import { StoreContext } from "../../store/StoreContext";

const Layout = ({ children, menu = "", submenu = "" }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  return (
    <>
      {/* HEADER */}
      <Header />

      {/* NAVIGATION */}
      <Navigation menu={menu} submenu={submenu} navigationList={navList} />

      {/* BODY */}
      <div className="wrapper">{children}</div>

      {/* MODAL SUCCESS */}
      {store.success && <ModalSuccess />}
    </>
  );
};

export default Layout;
```

**src/pages/developer/nav-function.jsx**

```jsx
import { MdDashboard } from "react-icons/md";
import { devNavUrl, urlDeveloper } from "../../functions/functions-general";
import { FaCogs, FaUsers } from "react-icons/fa";

export const navList = [
  {
    label: "Donor List",
    icon: <MdDashboard />,
    menu: "donorlist",
    path: `${devNavUrl}/${urlDeveloper}/donorlist`,
    submenu: "",
  },
  {
    label: "Settings",
    icon: <FaCogs />,
    menu: "settings",
    submenu: "",
    subNavList: [
      {
        label: "Users",
        submenu: "users",
        path: `${devNavUrl}/${urlDeveloper}/settings/users`,
      },
    ],
  },
];
```

**src/partials/Navigation.jsx**

```jsx
import React from "react";
import { StoreContext } from "../store/StoreContext";
import { Link } from "react-router-dom";
import NavigationAccordions from "./NavigationAccordions";

const Navigation = ({ navigationList = [], menu = "", submenu = "" }) => {
  const { store } = React.useContext(StoreContext);
  const scrollRef = React.useRef(null);

  return (
    <>
      <div className="print:hidden">
        <nav
          className={`${
            store.isShow ? "translate-x-0" : ""
          } h-dvh duration-200 ease-in fixed z-40  overflow-y-auto w-[14rem] print:hidden py-3 uppercase pt-[76px]`}
          ref={scrollRef}
        >
          <div className="text-sm text-white flex flex-col justify-between h-full">
            <ul>
              {navigationList.map((item, key) => {
                return (
                  <li
                    key={key}
                    className={`h-fit flex items-center gap-2 ${
                      item.subNavList && "flex-col gap-0.5!"
                    }`}
                  >
                    {item.subNavList ? (
                      <NavigationAccordions
                        subNavList={item.subNavList}
                        item={item}
                        menu={menu}
                        submenu={submenu}
                      />
                    ) : (
                      <Link
                        to={item.path}
                        className={`w-full px-4 py-3 hover:bg-gray-50/10 ${
                          menu === item.menu ? "bg-black/10" : ""
                        }`}
                      >
                        <div className="flex items-center gap-2 text-base">
                          {item.icon} {item.label}
                        </div>
                      </Link>
                    )}
                  </li>
                );
              })}
            </ul>
          </div>
        </nav>
      </div>
    </>
  );
};

export default Navigation;
```

**src/partials/NavigationAccordions.jsx**

```jsx
import React from "react";
import { FaChevronDown } from "react-icons/fa";
import { Link } from "react-router-dom";

const NavigationAccordions = ({
  subNavList = [],
  item,
  menu = "",
  submenu = "",
}) => {
  const hasActiveChild = menu === item.menu;
  const [isOpen, setIsOpen] = React.useState(false);
  const isExpanded = hasActiveChild || isOpen;

  return (
    <>
      <button
        className={`w-full px-4 py-3 hover:bg-gray-50/10 flex justify-between gap-2 ${
          hasActiveChild ? "bg-black/10" : ""
        }`}
        onClick={() => setIsOpen(!isOpen)}
      >
        <div className="flex items-center gap-2 text-base">
          {item.icon} {item.label}
        </div>
        <FaChevronDown
          className={`mt-1 text-xs transition-transform duration-200 ${
            isExpanded ? "rotate-180" : ""
          }`}
        />
      </button>
      {isExpanded && (
        <ul className="self-start w-full bg-primary/95 pb-2">
          {subNavList.map((item, key) => {
            return (
              <li key={key} className="w-full ">
                <Link
                  to={item.path}
                  className={`block hover:bg-gray-50/10 pl-10 pr-4 py-2 text-base normal-case ${
                    submenu === item.submenu
                      ? "text-[#ffc857] border-l-4 border-[#ffc857]"
                      : ""
                  }`}
                >
                  {item.label}
                </Link>
              </li>
            );
          })}
        </ul>
      )}
    </>
  );
};

export default NavigationAccordions;
```

**src/partials/Header.jsx**

```jsx
import React from "react";
import { FaIndent } from "react-icons/fa";
import { MdOutlineLogout, MdOutlineMailOutline } from "react-icons/md";
import { devNavUrl, urlDeveloper } from "../functions/functions-general";
import ftcLogo from "../assets/ftc_logo.png";

const Header = () => {
  const [show, setShow] = React.useState(false);
  const ref = React.useRef();
  const link = `${devNavUrl}/${urlDeveloper}`;
  let menuRef = React.useRef();

  const roleIsDeveloper = true;
  const firstName = roleIsDeveloper ? "John" : "James";
  const lastName = roleIsDeveloper ? "Doe" : "Gun";
  const email = roleIsDeveloper ? "john@gmail.com" : "gun@gmail.com";
  const nickName = "JD";
  const handleShowNavigation = () => {};
  const handleLogout = () => {
    console.log("Logout clicked");
  };

  return (
    <>
      <div className="print:hidden fixed z-[52] bg-white w-full flex justify-between items-center h-16 border-solid border-b-2 border-primary px-2">
        <div className="flex items-center lg:w-full lg:justify-normal relative z-10">
          <div className="group-hover:opacity-20 flex items-center lg:justify-start lg:min-h-[44px] lg:min-w-[170px] max-h-[44px] max-w-[170px] m-0.5">
            <button
              onClick={handleShowNavigation}
              className={`py-4 pl-1 pr-4 text-gray-600 bg-white z-50 flex items-center rounded-br-sm focus:outline-0 cursor-pointer duration-200 ease-in`}
            >
              <FaIndent />
            </button>
            <div className="pl-1 flex items-center">
              <img
                src={ftcLogo}
                alt="Face the Children"
                className="h-10 w-auto object-contain"
              />
            </div>
          </div>
        </div>

        <div className="header__avatar pr-0 lg:pr-1" ref={ref}>
          <div className="flex items-center pr-2 px-1 gap-2 xl:py-2 lg:pl-4 group cursor-pointer">
            <div
              className={`p-[1px] duration-[50ms] ease-out border-2 border-transparent hover:border-2 hover:border-primary hover:border-opacity-50 rounded-full ${
                show ? "!border-primary" : "!border-opacity-50"
              }`}
            >
              <div className="flex bg-primary rounded-full justify-center items-center min-w-[2rem] min-h-[2rem] max-w-[2rem] max-h-[2rem] text-white pt-0.5 uppercase">
                {nickName}
              </div>
            </div>
          </div>

          <div
            className={`dropdown ${
              show ? "active" : "inactive"
            } p-2 min-w-[250px] overflow-hidden rounded-md fixed right-4 drop-shadow-sm border border-gray-200 bg-white z-20 transition-all ease-in-out duration-200 transform -translate-x-1 block`}
            ref={menuRef}
          >
            <div className="text-xs p-1">
              <ul className="p-2">
                <li className="mb-0 font-bold capitalize text-sm">
                  {firstName} {lastName}
                </li>
                <li className="mb-0 pb-2 capitalize text-xs">Developer</li>
                <li className="pb-2 flex items-center gap-2 text-xs">
                  <MdOutlineMailOutline />
                  {email}
                </li>
                <button
                  onClick={() => handleLogout()}
                  className="hover:text-primary flex items-center gap-2 pt-2 w-full"
                >
                  <MdOutlineLogout />
                  Logout
                </button>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Header;
```

---

## 4. PAGES & COMPONENTS

### 4.1 Users Page (Settings)

**src/pages/developer/settings/users/Users.jsx**

```jsx
import React from "react";
import { FaChevronRight, FaUserCircle } from "react-icons/fa";
import Layout from "../../Layout";

const userItems = [
  { label: "System user" },
  { label: "Other user" },
  { label: "Roles" },
];

const Users = () => {
  return (
    <>
      <Layout menu="settings" submenu="users">
        <div className="flex min-h-[calc(100dvh-6rem)] flex-col">
          <div className="max-w-5xl w-full pt-4">
            <div className="flex items-center justify-between w-full">
              <h1 className="text-[2rem] leading-none text-dark">Users</h1>
            </div>

            <div className="pt-10">
              {userItems.map((item) => (
                <button
                  key={item.label}
                  type="button"
                  className="flex w-full items-center justify-between border-b border-gray-300 py-5 text-left text-[1.7rem] font-semibold text-dark transition-colors hover:text-primary"
                >
                  <span className="flex items-center gap-4">
                    <FaUserCircle className="text-[1.6rem]" />
                    {item.label}
                  </span>
                  <FaChevronRight className="text-[1.5rem] font-normal text-gray-700" />
                </button>
              ))}
            </div>
          </div>

          <div className="mt-auto pt-12 pb-4 text-center text-base text-dark">
            <p className="mb-2">Copyright 2026. All rights reserved.</p>
            <p className="mb-0">
              Powered by{" "}
              <span className="text-primary">
                Frontline Business Solutions, Inc.
              </span>
            </p>
          </div>
        </div>
      </Layout>
    </>
  );
};

export default Users;
```

### 4.2 Donors List Page

**src/pages/developer/donorlist/Donors.jsx**

```jsx
import React from "react";
import Layout from "../Layout";
import { FaPlus } from "react-icons/fa";
import { StoreContext } from "../../../store/StoreContext";
import DonorsList from "./DonorsList";
import { setIsAdd } from "../../../store/StoreAction";
import ModalAddDonors from "./ModalAddDonors";

const Donors = () => {
  const { store, dispatch } = React.useContext(StoreContext);
  const [itemEdit, setItemEdit] = React.useState(null);

  const handleAdd = () => {
    dispatch(setIsAdd(true));
    setItemEdit(null);
  };

  return (
    <>
      <Layout menu="donors">
        <div className="flex items-center justify-between w-full">
          <h1>Donors</h1>
          <div>
            <button
              type="button"
              className="flex items-center gap-1 hover:underline"
              onClick={handleAdd}
            >
              <FaPlus className="text-primary" />
              add
            </button>
          </div>
        </div>
        <div>
          <DonorsList itemEdit={itemEdit} setItemEdit={setItemEdit} />
        </div>
      </Layout>

      {store.isAdd && <ModalAddDonors itemEdit={itemEdit} />}
    </>
  );
};

export default Donors;
```

**src/pages/developer/donorlist/DonorsList.jsx**

```jsx
import React from "react";
import { StoreContext } from "../../../store/StoreContext";
import { useInfiniteQuery } from "@tanstack/react-query";
import { queryDataInfinite } from "../../../functions/custom-hooks/queryDataInfinite";
import { apiVersion } from "../../../functions/functions-general";
import { useInView } from "react-intersection-observer";
import NoData from "../../../partials/NoData";
import ServerError from "../../../partials/ServerError";
import TableLoading from "../../../partials/TableLoading";
import FetchingSpinner from "../../../partials/spinners/FetchingSpinner";
import Loadmore from "../../../partials/Loadmore";
import Status from "../../../partials/Status";
import { FaArchive, FaEdit, FaTrash, FaTrashRestore } from "react-icons/fa";
import {
  setIsAdd,
  setIsArchive,
  setIsDelete,
  setIsRestore,
} from "../../../store/StoreAction";
import ModalArchive from "../../../partials/modals/ModalArchive";
import ModalRestore from "../../../partials/modals/ModalRestore";
import ModalDelete from "../../../partials/modals/ModalDelete";
import SearchBar from "../../../partials/SearchBar";

const DonorsList = ({ itemEdit, setItemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);

  const [page, setPage] = React.useState(1);
  const [filterData, setFilterData] = React.useState(null);
  const [onSearch, setOnSearch] = React.useState(false);
  const search = React.useRef({ value: "" });
  const { ref, inView } = useInView();
  let counter = 1;

  const {
    data: result,
    error,
    fetchNextPage,
    hasNextPage,
    isFetching,
    isFetchingNextPage,
    status,
  } = useInfiniteQuery({
    queryKey: ["donors", search.current.value, store.isSearch, filterData],
    queryFn: async ({ pageParam = 1 }) =>
      await queryDataInfinite(
        ``,
        `${apiVersion}/controllers/developers/donors/page.php?start=${pageParam}`,
        false,
        {
          filterData,
          searchValue: search?.current?.value,
        },
        `post`
      ),
    getNextPageParam: (lastPage) => {
      if (lastPage.page < lastPage.total) {
        return lastPage.page + lastPage.count;
      }
      return;
    },
    refetchOnWindowFocus: false,
  });

  React.useEffect(() => {
    if (inView) {
      setPage((prev) => prev + 1);
      fetchNextPage();
    }
  }, [inView]);

  const handleEdit = (item) => {
    dispatch(setIsAdd(true));
    setItemEdit(item);
  };
  const handleArchive = (item) => {
    dispatch(setIsArchive(true));
    setItemEdit(item);
  };
  const handleRestore = (item) => {
    dispatch(setIsRestore(true));
    setItemEdit(item);
  };
  const handleDelete = (item) => {
    dispatch(setIsDelete(true));
    setItemEdit(item);
  };

  return (
    <>
      <div className="pt-5 pb-2 flex items-center justify-between">
        <div className="relative">
          <label htmlFor="">Status</label>
          <select
            onChange={(e) => setFilterData(e.target.value)}
            value={filterData || ""}
          >
            <option value="">All</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>
        <SearchBar
          search={search}
          dispatch={dispatch}
          store={store}
          result={result?.pages}
          isFetching={isFetching}
          setOnSearch={setOnSearch}
          onSearch={onSearch}
        />
      </div>

      <div className="relative pt-4 rounded-md">
        {status !== "pending" && isFetching && <FetchingSpinner />}
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Status</th>
              <th>Name</th>
              <th>Birth Date</th>
              <th>Age</th>
              <th>Residency Status</th>
              <th>Donation Limit</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            {!error &&
              (status == "pending" || result?.pages[0]?.count == 0) && (
                <tr>
                  <td colSpan="100%" className="p-10">
                    {status == "pending" ? (
                      <TableLoading cols={2} count={20} />
                    ) : (
                      <NoData />
                    )}
                  </td>
                </tr>
              )}
            {error && (
              <tr>
                <td colSpan="100%" className="p-10">
                  <ServerError />
                </td>
              </tr>
            )}
            {result?.pages?.map((page, key) => (
              <React.Fragment key={key}>
                {page.data?.map((item, key2) => {
                  return (
                    <tr key={key2}>
                      <td>{counter++}.</td>
                      <td>
                        <Status
                          text={`${
                            item.donor_is_active == 1 ? "active" : "inactive"
                          }`}
                        />
                      </td>
                      <td>{`${item.donor_first_name} ${item.donor_last_name}`}</td>
                      <td>{item.donor_birth_date}</td>
                      <td>{item.donor_age}</td>
                      <td>{item.donor_residency_status || "--"}</td>
                      <td>$ {item.donor_donation_limit || "--"}</td>
                      <td>
                        <div className="flex items-center gap-3">
                          {item.donor_is_active == 1 ? (
                            <>
                              <button
                                type="button"
                                className="tooltip-action-table"
                                data-tooltip="Edit"
                                onClick={() => handleEdit(item)}
                              >
                                <FaEdit />
                              </button>
                              <button
                                type="button"
                                className="tooltip-action-table"
                                data-tooltip="Archive"
                                onClick={() => handleArchive(item)}
                              >
                                <FaArchive />
                              </button>
                            </>
                          ) : (
                            <>
                              <button
                                type="button"
                                className="tooltip-action-table"
                                data-tooltip="Restore"
                                onClick={() => handleRestore(item)}
                              >
                                <FaTrashRestore />
                              </button>
                              <button
                                type="button"
                                className="tooltip-action-table"
                                data-tooltip="Delete"
                                onClick={() => handleDelete(item)}
                              >
                                <FaTrash />
                              </button>
                            </>
                          )}
                        </div>
                      </td>
                    </tr>
                  );
                })}
              </React.Fragment>
            ))}
          </tbody>
        </table>
        <div className="loadmore flex justify-center flex-col items-center pb-10">
          <Loadmore
            fetchNextPage={fetchNextPage}
            isFetchingNextPage={isFetchingNextPage}
            hasNextPage={hasNextPage}
            result={result?.pages[0]}
            setPage={setPage}
            page={page}
            refView={ref}
            isSearchOrFilter={store.isSearch || result?.isFilter}
          />
        </div>
      </div>

      {store.isArchive && (
        <ModalArchive
          mysqlApiArchive={`${apiVersion}/controllers/developers/donors/active.php?id=${itemEdit.donor_aid}`}
          msg="Are you sure you want to archive this record?"
          successMsg="Successfully archived record!"
          item={itemEdit.donor_first_name}
          dataItem={itemEdit}
          queryKey={"donors"}
        />
      )}

      {store.isRestore && (
        <ModalRestore
          mysqlApiRestore={`${apiVersion}/controllers/developers/donors/active.php?id=${itemEdit.donor_aid}`}
          msg="Are you sure you want to restore this record?"
          successMsg="Successfully restore record!"
          item={itemEdit.donor_first_name}
          dataItem={itemEdit}
          queryKey={"donors"}
        />
      )}

      {store.isDelete && (
        <ModalDelete
          mysqlApiDelete={`${apiVersion}/controllers/developers/donors/delete.php?id=${itemEdit.donor_aid}`}
          msg="Are you sure you want to delete this record?"
          successMsg="Successfully deleted!"
          item={itemEdit.donor_first_name}
          dataItem={itemEdit}
          queryKey={"donors"}
        />
      )}
    </>
  );
};

export default DonorsList;
```

### 4.3 Modal Add/Edit Donors

**src/pages/developer/donorlist/ModalAddDonors.jsx**

```jsx
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { Form, Formik } from "formik";
import React from "react";
import { FaTimes } from "react-icons/fa";
import * as Yup from "yup";
import { queryData } from "../../../functions/custom-hooks/queryData";
import { apiVersion } from "../../../functions/functions-general";
import {
  setError,
  setIsAdd,
  setMessage,
  setSuccess,
} from "../../../store/StoreAction";
import { StoreContext } from "../../../store/StoreContext";
import ModalWrapperSide from "../../../partials/modals/ModalWrapperSide";
import MessageError from "../../../partials/MessageError";
import ButtonSpinner from "../../../partials/spinners/ButtonSpinner";
import { InputText } from "../../../components/form-input/FormInputs";

const ModalAddDonors = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);

  const QueryClient = useQueryClient();
  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/donors/donor.php?id=${itemEdit.donor_id}`
          : `${apiVersion}/controllers/developers/donors/donor.php`,
        itemEdit ? "put" : "post",
        values
      ),
    onSuccess: (data) => {
      QueryClient.invalidateQueries({ queryKey: ["donors"] });
      if (data.success) {
        dispatch(setSuccess(true));
        dispatch(setMessage(`Successfully ${itemEdit ? "updated" : "added"}`));
        dispatch(setIsAdd(false));
      }
      if (data.success == false) {
        dispatch(setError(true));
        dispatch(setMessage(data.error));
      }
    },
  });

  const initVal = {
    ...itemEdit,
    department_name: itemEdit ? itemEdit.department_name : "",
    department_name_old: itemEdit ? itemEdit.department_name : "",
  };
  const yupSchema = Yup.object({
    department_name: Yup.string().trim().required("required"),
  });

  const handleClose = () => {
    dispatch(setIsAdd(false));
  };

  React.useEffect(() => {
    dispatch(setError(false));
  }, []);

  return (
    <>
      <ModalWrapperSide
        handleClose={handleClose}
        className="transition-all ease-in-out transform duration-200"
      >
        <div className="modal-header relative mb-4">
          <h3 className="text-dark text-sm">
            {itemEdit ? "Update" : "Add"} Department
          </h3>
          <button
            type="button"
            className="absolute top-0 right-4"
            onClick={handleClose}
          >
            <FaTimes />
          </button>
        </div>
        <div className="modal-body">
          <Formik
            initialValues={initVal}
            validationSchema={yupSchema}
            onSubmit={async (values, { setSubmitting, resetForm }) => {
              dispatch(setError(false));
              mutation.mutate(values);
            }}
          >
            {(props) => {
              return (
                <Form className="h-full">
                  <div className="modal-form-container">
                    <div className="modal-container">
                      <div className="relative mb-6">
                        <InputText
                          label="Department Name"
                          name="department_name"
                          type="text"
                          disabled={mutation.isPending}
                        />
                      </div>
                      {store.error && <MessageError />}
                    </div>
                    <div className="modal-action">
                      <button
                        type="submit"
                        disabled={mutation.isPending || !props.dirty}
                        className="btn-modal-submit"
                      >
                        {mutation.isPending ? (
                          <ButtonSpinner />
                        ) : itemEdit ? (
                          "Save"
                        ) : (
                          "Add"
                        )}
                      </button>
                      <button
                        type="reset"
                        className="btn-modal-cancel"
                        onClick={handleClose}
                        disabled={mutation.isPending}
                      >
                        Cancel
                      </button>
                    </div>
                  </div>
                </Form>
              );
            }}
          </Formik>
        </div>
      </ModalWrapperSide>
    </>
  );
};

export default ModalAddDonors;
```

### 4.4 Form Input Components

**src/components/form-input/FormInputs.jsx**

```jsx
import { useField } from "formik";
import React from "react";
import { FaCheck } from "react-icons/fa";
import { FaCircleCheck } from "react-icons/fa6";
import { setError } from "../../store/StoreAction";
import { StoreContext } from "../../store/StoreContext";
import { NumericFormat } from "react-number-format";

export const InputText = ({
  label = "",
  required = true,
  className = "",
  onChange = null,
  refVal = null,
  ...props
}) => {
  const { dispatch } = React.useContext(StoreContext);
  const [field, meta] = useField(props);

  if (props.number === "number") {
    return (
      <>
        {label !== "" && (
          <label htmlFor={props.id || props.name}>
            {required && <span className="text-alert">*</span>}
            {label}
          </label>
        )}
        <NumericFormat
          {...field}
          {...props}
          allowLeadingZeros
          autoComplete="off"
          className={`${
            meta.touched && meta.error ? "error-show" : null
          }  ${className}`}
          onChange={(e) => {
            onChange !== null && onChange(e);
            field.onChange(e);
            dispatch(setError(false));
          }}
        />
        {meta.touched && meta.error ? (
          <span className={`error-show`}>{meta.error}</span>
        ) : null}
      </>
    );
  }

  return (
    <>
      <input
        {...field}
        {...props}
        className={`${
          meta.touched && meta.error ? `error-show ` : ""
        } ${className} `}
        autoComplete="off"
        onChange={(e) => {
          onChange !== null && onChange(e);
          field.onChange(e);
        }}
        ref={refVal}
      />
      {label !== "" && typeof label !== "undefined" && (
        <label htmlFor={props.id || props.name}>
          {required && <span className="text-alert">*</span>}
          {label}
        </label>
      )}
      {meta.touched && meta.error ? (
        <span className="error-show">{meta.error}</span>
      ) : null}
    </>
  );
};

export const InputSelect = ({
  label,
  required = true,
  onChange = null,
  ...props
}) => {
  const { dispatch } = React.useContext(StoreContext);
  const [field, meta] = useField(props);

  return (
    <>
      <label htmlFor={props.id || props.name}>
        {required && <span className="text-alert">*</span>}
        {label}
      </label>
      <select
        {...field}
        {...props}
        className={meta.touched && meta.error ? "error-show" : null}
        onChange={(e) => {
          onChange !== null && onChange(e);
          field.onChange(e);
          dispatch(setError(false));
        }}
        autoComplete="off"
      />
      {meta.touched && meta.error ? (
        <span className="error-show">{meta.error}</span>
      ) : null}
    </>
  );
};

export const InputTextArea = ({
  label = "",
  required = true,
  onChange = null,
  className = "",
  ...props
}) => {
  const { dispatch } = React.useContext(StoreContext);
  const [field, meta] = useField(props);

  return (
    <>
      {label !== "" && (
        <label htmlFor={props.id || props.name}>
          {required && <span className="text-alert">*</span>}
          {label}
        </label>
      )}
      <textarea
        className={
          meta.touched && meta.error ? `error-show ${className}` : className
        }
        {...field}
        {...props}
        autoComplete="off"
        onChange={(e) => {
          onChange !== null && onChange(e);
          field.onChange(e);
          dispatch(setError(false));
        }}
      ></textarea>
      {meta.touched && meta.error ? (
        <span className="error-show">{meta.error}</span>
      ) : null}
    </>
  );
};

export const InputCheckbox = ({
  label,
  onChange = null,
  required = false,
  ...props
}) => {
  const { dispatch } = React.useContext(StoreContext);
  const [field, meta] = useField(props);
  return (
    <>
      <div className="flex items-center gap-2">
        <div
          className="relative flex cursor-pointer items-center justify-center rounded-full"
          htmlFor={props.id || props.name}
        >
          <input
            checked={field.value}
            value={field.value}
            {...field}
            {...props}
            className={
              meta.touched && meta.error
                ? "w-auto h-auto error-show"
                : "p-1.5 before:content-[''] peer relative h-auto w-auto cursor-pointer border-accent appearance-none rounded-sm transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:-translate-y-2/4 before:-translate-x-2/4 before:opacity-0 before:transition-opacity checked:bg-accent"
            }
            type="checkbox"
            onChange={(e) => {
              onChange !== null && onChange(e);
              field.onChange(e);
              dispatch(setError(false));
            }}
          />
          <span className="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
            <FaCheck className="h-3 w-3" />
          </span>
        </div>
        <label htmlFor={props.id || props.name}>
          {label}
          {required && <span className="text-alert">*</span>}
        </label>
      </div>
    </>
  );
};

export const InputRadioButton = ({ label, onChange = null, ...props }) => {
  const { dispatch } = React.useContext(StoreContext);
  const [field, meta] = useField(props);
  return (
    <>
      <div className="flex items-center pl-0 w-fit relative">
        <span className="relative flex cursor-pointer items-center rounded-full ">
          <input
            checked={field.value}
            value={field.value}
            {...field}
            {...props}
            type="radio"
            className={
              meta.touched && meta.error
                ? "peer relative h-4 w-4 cursor-pointer appearance-none rounded-full border text-accent transition-all error-show"
                : "peer relative h-4 w-4 cursor-pointer appearance-none rounded-full border text-accent transition-all"
            }
            onChange={(e) => {
              onChange !== null && onChange(e);
              field.onChange(e);
              dispatch(setError(false));
            }}
          />
          <div className="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-accent opacity-0 transition-opacity peer-checked:opacity-100 peer-hover:opacity-100">
            <FaCircleCheck className="h-3.5 w-3.5 fill-current" />
          </div>
        </span>
        <label htmlFor={props.id || props.name}>{label}</label>
      </div>
    </>
  );
};

export const InputPhotoUpload = ({ label, ...props }) => {
  const [field, meta] = useField(props);
  return (
    <>
      <input {...field} {...props} />
      {meta.touched && meta.error ? (
        <span className="error--msg">{meta.error}</span>
      ) : null}
    </>
  );
};

export const InputFileUpload = ({ label, ...props }) => {
  const [field, meta] = useField(props);
  return (
    <>
      <input {...field} {...props} />
      {meta.touched && meta.error ? (
        <span className="error--msg">{meta.error}</span>
      ) : null}
    </>
  );
};

export const InputCode = ({ length, loading, onComplete }) => {
  const [code, setCode] = React.useState([...Array(length)].map(() => ""));
  const inputs = React.useRef([]);

  const processInput = (e, slot) => {
    const num = e.target.value;
    if (/[^0-9]/.test(num)) return;

    let newCode = [...code];
    // ... logic for processing code input
    setCode(newCode);
    if (newCode.every((num) => num !== "")) {
      onComplete(newCode.join(""));
    }
  };

  // ... additional OTP code input logic
};
```

---

## 5. BACKEND (PHP REST API)

### 5.1 Database Connection

**rest/v1/core/Database.php**

```php
<?php
class Database
{
    private static $dbConnection;

    public static function connectDb()
    {
        $host = "localhost";
        $dbname = "viter_ftcd_v1";
        $username = "root";
        $password = "";

        if (self::$dbConnection === null) {
            self::$dbConnection = new PDO(
                "mysql:host={$host};dbname={$dbname};",
                $username,
                $password,
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
            self::$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$dbConnection;
    }
}
```

### 5.2 Response Handler

**rest/v1/core/Response.php**

```php
<?php
class Response
{
    private $_success;
    private $_data;
    private $_toCache = false;
    private $_responseData = array();

    public function setSuccess($success)
    {
        $this->_success = $success;
    }
    public function setData($data)
    {
        $this->_data = $data;
    }
    public function toCache($toCache)
    {
        $this->_toCache = $toCache;
    }
    public function send()
    {
        header("Content-Type: application/json;charset=UTF-8");
        if ($this->_toCache == true) {
            header("Cache-Control: max-age=60");
        } else {
            header("Cache-Control: no-cache, no-store");
        }
        $this->_responseData = $this->_data;
        echo json_encode($this->_responseData);
    }
}
```

### 5.3 API Functions

**rest/v1/core/functions.php**

```php
<?php
require 'Database.php';
require 'Response.php';

// Send JSON Response
function sendResponse($result)
{
    $response = new Response();
    $response->setSuccess(true);
    $response->setData($result);
    $response->send();
}

// Check database connection
function checkDbConnection()
{
    try {
        $conn = Database::connectDb();
        return $conn;
    } catch (PDOException $error) {
        // Return error response
        $response = new Response();
        $error = [
            'type' => "Invalid_request_error",
            'success' => false,
            'error' => "Database connection failed"
        ];
        $response->setData($error);
        $response->send();
        exit;
    }
}

// Check payload from frontend
function checkPayload($jsonData)
{
    if (empty($jsonData) || $jsonData === null) {
        invalidInput();
    }
}

// Get payload value by index
function checkIndex($jsonData, $index)
{
    if (!isset($jsonData[$index]) || $jsonData[$index] === "") {
        invalidInput();
    }
    return trim($jsonData[$index]);
}

// CRUD Helper Functions
function checkCreate($object) { $query = $object->create(); checkQuery($query, "There's a problem processing your request. (create)"); return $query; }
function checkReadLimit($object) { $query = $object->readLimit(); checkQuery($query, "Empty records. (limit)"); return $query; }
function checkReadAll($object) { $query = $object->readAll(); checkQuery($query, "Empty records. (read All)"); return $query; }
function checkUpdate($object) { $query = $object->update(); checkQuery($query, "There's a problem processing your request. (update)"); return $query; }
function checkActive($object)
```
