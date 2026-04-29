import { getUserType } from "../functions/functions-general";
import { FaScrewdriverWrench } from "react-icons/fa6";
import { Link } from "react-router-dom";

const ComeBackLater = () => {
  const link = getUserType();

  return (
    <>
      <div className="flex items-center justify-center flex-col gap-2 h-[70vh] p-5">
        <Link to={`${link}/`} className="ml-2.5 p-1">
          <span className="text-sm font-semibold text-primary">FTCD</span>
        </Link>
        <span className="text-6xl my-2">
          <FaScrewdriverWrench />
        </span>
        <h3 className="text-base my-2 font-normal">
          Please check back later. This service is temporarily unavailable.
        </h3>
        <Link to={`${link}/`} className="underline text-primary">
          Home
        </Link>
      </div>
    </>
  );
};

export default ComeBackLater;
