using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task1
{
    interface ICommentable
    {
        List<string> Comments { get; set; }
        void AddComment(string comment);
    }
}
