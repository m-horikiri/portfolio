import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
  faHtml5,
  faCss3,
  faJs,
  faPhp,
  faGit,
  faWordpress,
  faDocker,
} from '@fortawesome/free-brands-svg-icons';
import {
  faComputer,
  faStar as faStarSolid,
  faCode,
  faCamera,
  faIcons,
} from '@fortawesome/free-solid-svg-icons';
import { faStar as faStarRegular } from '@fortawesome/free-regular-svg-icons';
import { motion } from 'framer-motion';

export default function Skills() {
  const categories = [
    {
      title: '言語',
      color: 'from-pink-100 to-pink-50',
      text: 'text-pink-500',
      items: [
        { label: 'HTML5', icon: faHtml5, stars: 5 },
        { label: 'CSS3', icon: faCss3, stars: 5 },
        { label: 'JavaScript', icon: faJs, stars: 4 },
        { label: 'PHP', icon: faPhp, stars: 4 },
      ],
    },
    {
      title: 'フレームワーク',
      color: 'from-purple-100 to-purple-50',
      text: 'text-purple-500',
      items: [
        { label: 'jQuery', icon: faCode, stars: 5 },
        { label: 'TypeScript', icon: faCode, stars: 4 },
        { label: 'React', icon: faCode, stars: 3 },
        { label: 'Laravel', icon: faCode, stars: 2 },
      ],
    },
    {
      title: 'その他',
      color: 'from-indigo-100 to-indigo-50',
      text: 'text-indigo-500',
      items: [
        { label: 'Git', icon: faGit, stars: 4 },
        { label: 'WordPress', icon: faWordpress, stars: 5 },
        { label: 'Docker', icon: faDocker, stars: 2 },
      ],
    },
    {
      title: 'デザイン',
      color: 'from-green-100 to-green-50',
      text: 'text-green-500',
      items: [
        { label: 'Photoshop', icon: faCamera, stars: 3 },
        { label: 'Illustrator', icon: faIcons, stars: 3 },
        { label: 'Figma', icon: faIcons, stars: 3 },
      ],
    },
  ];

  return (
    <div className="py-10 bg-purple-50">
      <div className="max-w-5xl mx-auto px-6">
        <h2 className="text-3xl font-bold text-purple-600 text-center mb-10 border-b-4 border-purple-200 pb-2">
          <FontAwesomeIcon icon={faComputer} className="mr-2" />
          Skills
        </h2>

        <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
          {categories.map((category) => (
            <div
              key={category.title}
              className={`rounded-xl shadow-lg p-6 bg-gradient-to-br ${category.color}`}
            >
              <h3
                className={`text-xl font-semibold mb-4 ${category.text} border-b border-opacity-50`}
              >
                {category.title}
              </h3>
              <dl className="space-y-4">
                {category.items.map((item) => (
                  <div key={item.label}>
                    <dt className="flex items-center gap-2 font-medium text-gray-700">
                      <FontAwesomeIcon
                        icon={item.icon}
                        className={`${category.text}`}
                      />
                      {item.label}
                    </dt>
                    <dd className="mt-1 flex gap-1">
                      {Array.from({ length: 5 }).map((_, i) => (
                        <motion.span
                          key={i}
                          initial={{ opacity: 0, y: -5 }}
                          animate={{ opacity: 1, y: 0 }}
                          transition={{ delay: i * 0.05 }}
                        >
                          <FontAwesomeIcon
                            icon={i < item.stars ? faStarSolid : faStarRegular}
                            className="text-yellow-400 w-4 h-4"
                          />
                        </motion.span>
                      ))}
                    </dd>
                  </div>
                ))}
              </dl>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
