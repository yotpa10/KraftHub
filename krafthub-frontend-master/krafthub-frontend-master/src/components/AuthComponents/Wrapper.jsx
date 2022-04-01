import React from "react";

const Wrapper = ({ children }) => {
  if (localStorage.getItem('token')) {
    window.location.replace("/home");
  }

  return (
    <div className="auth-wrapper">
      <div className="auth-inner">
        <h2 className="text-center mb-3">KraftHub</h2>
        {children}
      </div>
    </div>
  );
};


export default Wrapper;