const { colors } = require("tailwindcss/defaulttheme");

module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
    container: {
      center: true,
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require("@tailwindcss/forms")({
      strategy: "class",
    }),
  ],
};

// module.exports = {
//   darkMode: false, // or 'media' or 'class'
//   theme: {
//     extend: {},
//     screens: {
//       sm: "640px",
//       // => @media (min-width: 640px) { ... }

//       md: "768px",
//       // => @media (min-width: 768px) { ... }

//       lg: "1024px",
//       // => @media (min-width: 1024px) { ... }

//       xl: "1280px",
//       // => @media (min-width: 1280px) { ... }

//       "2xl": "1920px",
//       // => @media (min-width: 1536px) { ... }
//     },
//     container: {
//       center: true,
//       screens: {
//         sm: "640px",
//         md: "768px",
//         lg: "960px",
//         xl: "960px",
//         "2xl": "960px",
//       },
//     },
//     backgroundColor: (theme) => ({
//       primary: "#0c002a",
//       secondary: "#200a43",
//       danger: "#e3342f",
//     }),
//     borderColor: (theme) => ({
//       DEFAULT: theme("colors.gray.300", "currentColor"),
//       primary: "#2a1f48",
//       secondary: "#0c002a",
//       danger: "#e3342f",
//     }),
//   },
//   variants: {
//     extend: {},
//     //backgroundColor: ['active'],
//   },
// };
