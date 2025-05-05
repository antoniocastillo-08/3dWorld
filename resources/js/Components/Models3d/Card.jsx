import React from 'react';
import styled from 'styled-components';

const Card = ({ name, image }) => {
  return (
    <StyledWrapper>
      <div className="card">
        <div className="first-content">
          <img src={image} alt={name} className="image-full" />
        </div>
        <div className="second-content">
          <img src={image} alt={name} className="image-small" />
          <span className="name">{name}</span>
        </div>
      </div>
    </StyledWrapper>
  );
};

const StyledWrapper = styled.div`
  .card {
    width: 220px;
    height: 324px;
    background: rgb(103, 225, 255);
    transition: all 0.4s;
    border-radius: 10px;
    box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.705);
    overflow: hidden;
    position: relative;
  }

  .card:hover {
    border-radius: 15px;
    cursor: pointer;
    transform: scale(1.05);
    box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.705);
    background: rgb(103, 151, 255);
  }

  .first-content {
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all 0.4s;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
  }

  .first-content img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .card:hover .first-content {
    opacity: 0;
    transform: scale(0.9);
  }

  .second-content {
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 2;
    transition: all 0.4s;
  }

  .card:hover .second-content {
    opacity: 1;
  }

  .image-small {
    width: 100px;
    height: 150px;
    object-fit: cover;
    border-radius: 10%;
    margin-bottom: 10px;
  }

  .name {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 10px;
    text-align: center;
  }

  .download-button {
    padding: 8px 12px;
    background-color: #ff5722;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: background-color 0.3s;
  }

  .download-button:hover {
    background-color: #e64a19;
  }
`;

export default Card;