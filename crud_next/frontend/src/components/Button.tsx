import React from "react";

interface ButtonProps {
  text: string;
  color?: string;
  className?: string;
  onClick?: () => void;
}
// jocqjfjqo-fjwjf-owej-ofjwjgf0jgi0jwrijgieqj
const Button: React.FC<ButtonProps> = ({ text, color = "bg-blue-700", className = "", onClick }) => {
  return (
    <button
      className={`${color} px-4 py-2 rounded text-white ${className}`}
      onClick={onClick}
    >
      {text}
    </button>
  );
};

export default Button;
