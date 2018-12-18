const getters = {
  pageType: state => state.app.pageType,
  visitedViews: state => state.tagsView.visitedViews,
  cachedViews: state => state.tagsView.cachedViews,
  count: state => state.app.count
}

export default getters;
